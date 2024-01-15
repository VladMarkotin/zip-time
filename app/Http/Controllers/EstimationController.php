<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\SubPlanServices\CheckpointService;
use App\Http\Controllers\Services\EstimationService;
use App\Repositories\DayPlanRepositories\GetPlanRepository;
use App\Http\Controllers\NoteController;
use App\Models\Tasks;
use App\Models\SubPlan;

class EstimationController extends Controller
{
    private $currentPlanInfo   = null;
    private $checkCheckpoints  = null;
    private $estimationService = null;
    private $noteController    = null;

    public function __construct(
        CheckpointService $checkCheckpoints,
        EstimationService $estimationService,
        GetPlanRepository $getPlanRepository,
        NoteController $noteController
    )
    {
        $this->checkCheckpoints  = $checkCheckpoints;
        $this->estimationService = $estimationService;
        $this->currentPlanInfo   = $getPlanRepository;
        $this->noteController    = $noteController;
    }

    public function estimateTask(Request $request)
    {
        $task_id  =  $request->get('task_id');
        $doesUserHaveUncomplReqSubtask  = !$this->checkCheckpoints->checkCheckpoints(['task_id' => $task_id]);

        $currentMethod = $doesUserHaveUncomplReqSubtask
            ? 'estimateTaskWithUncomReqSubtask'
            : 'estimateTaskWithoutUncomReqSubtask';
        
        $response = $this->$currentMethod($request);
        
        return $response;
    }

    /**
     * I am waiting: {task_id: <id>, mark: <>, details: "", note: "" }
     */
    private function estimateTaskWithoutUncomReqSubtask(Request $request)
    {
        /**Before estimation check subplans */
        
        //раскомментить всю эту проверку, когда разделим логику по добавлению заметок и выставлению отметок
        // $checkSubPlan = $this->checkCheckpoints->checkCheckpoints(['task_id' => $request->get('task_id')]);
        // if (!$checkSubPlan) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Error! Some required subtasks are still undone',
        //     ]);
        // }
        
        //checkCheckpoints
        /**end */
        $isReady = null;
        $type = $request->get('type');
        $res = $request->get('is_ready');
        if (isset($res) && (in_array($type, [1, 2]))) {
            $isReady = intval($request->get('is_ready'));
            if ($isReady == 0)  {
                $isReady = ($isReady == 99) ? 50 : 99;
                $isReady = ($isReady == -1) ? 99 : -1;
            }
            //die(var_dump($isReady));
        }
        if (isset($isReady)) {
            $data = [
                "id"       => $request->get('task_id'),
                "details"  => $request->get('details'),
                "mark"     => $isReady,
                "note"     => $request->get('note'),
                "action"   => '1', //it means that user try to estimate one task
            ];
        } else {
            $data = [
                "id"       => $request->get('task_id'),
                "details"  => $request->get('details'),
                "note"     => $request->get('note'),
                "action"   => '1', //it means that user try to estimate one task
            ];
        }
        //$data['mark'] = -1;//default
        //estimateTask
        //just update task
        if (!$request->get('mark') && (!$request->get('is_ready'))
             && (in_array($type, [1,2])) ) {
            $data['action'] = '3';
            $checkedData = $this->estimationService->handleEstimationRequest($data);
            
            return json_encode(['status' => 'success', 'message' => 'Task has been updated.'], JSON_UNESCAPED_UNICODE);
        }
        $data['mark'] = ($request->get('mark') && (!$request->get('is_ready'))) ? 
            $request->get('mark') : $request->get('is_ready');
        $checkedData = $this->estimationService->handleEstimationRequest($data);
        if($checkedData) {
            $params        = ["id" => Auth::id(),"date" => Carbon::today()->toDateString()];
            $planForDay = $this->currentPlanInfo->getLastDayPlan($params); //получаю задания для составленного плана на день
            //get today`s note Amount
            $noteAmount = $this->noteController->countTodayNoteAmount($checkedData);

            return json_encode(['status' => 'success', 'message' => 'Task has been updated.',
             'noteAmount' => $noteAmount], JSON_UNESCAPED_UNICODE);
        }

        return json_encode(["status" => 'error', "message" => 'Error during estimation.'], JSON_UNESCAPED_UNICODE);
    }

    private function estimateTaskWithUncomReqSubtask(Request $request)
    {
        
        $task_id = $request->get('task_id');
        $note    = $request->get('note');
        $data    = ['id' => $task_id, 'note' => $note];
        
        $response = [
            'status' => 'error',
            'message' => 'Error! Some required subtasks are still undone',
        ];
        
        $addingNoteData = $this->noteController->addNote($data, false);

        if (($addingNoteData['status'] === 'success') && isset($addingNoteData['saved_task_id'])) {
            $noteAmount = $this->noteController->countTodayNoteAmount($data);
            $response['noteAmount'] = $noteAmount;
        }

        return response()->json($response);
    }
}
