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
use App\Events\FinishDayEvent;
use App\Events\CompleteTaskEvent;
use App\Listeners\FinishDayListener;
use App\Listeners\CompleteTaskListener;
use App\Events\RewardEvent;
use App\Models\ChallengeModel;
use Illuminate\Support\Facades\Validator;
use App\Models\TimetableModel;


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

        if ($doesUserHaveUncomplReqSubtask) {
            $response = [
                'status'  => 'error',
                'message' => 'Error! Some required subtasks are still undone',
            ];
        } else {
            $response = json_encode($this->estimateTaskWithoutUncomReqSubtask($request), JSON_UNESCAPED_UNICODE);
        }
        
        // $challengeModel = new ChallengeModel();    
        //RewardEvent::dispatch(['event_prefix' => ['estimate_task'] ]);

        return  $response;
    }

    public function saveComment(Request $request)
    {
        $rules = [
            'comment' => 'string|max:65535', // 65535 - максимальная длина типа TEXT в MySQL
        ];
        $validator = Validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $carbonDate = Carbon::parse($request->input('date'));
            // Форматирование даты в формат "Y-m-d"
            $formattedDate = $carbonDate->format('Y-m-d');
            $temp = TimetableModel::where([['date',$formattedDate], ['user_id', Auth::id()] ])
              ->update(['comment' => $request->input('comment')]);
            
            return response(['comment_updated_status' => !empty($temp) ? 'success' : 'eror'], 200);
        }
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
            
            return ['status' => 'success', 'message' => 'Task has been updated.'];
        }
        $data['mark'] = ($request->get('mark') && (!$request->get('is_ready'))) ? 
            $request->get('mark') : $request->get('is_ready');
        $checkedData = $this->estimationService->handleEstimationRequest($data);
        if($checkedData) {
            $params        = ["id" => Auth::id(),"date" => Carbon::today()->toDateString()];
            $planForDay = $this->currentPlanInfo->getLastDayPlan($params); //получаю задания для составленного плана на день
            //get today`s note Amount
            $noteAmount = $this->noteController->countTodayNoteAmount($checkedData);

            return ['status' => 'success', 'message' => 'Task has been updated.','noteAmount' => $noteAmount];
        }
        //если провалена проверка на валидность все равно надо добавить заметки

        $response = [
            "status" => 'error', 
            "message" => 'Error during estimation.'
        ];

        return $response;
    }
}
