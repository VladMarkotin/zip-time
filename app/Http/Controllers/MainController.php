<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 29.05.2021
 * Time: 7:52
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Services\GetDayPlanService;
use App\Repositories\DayPlanRepositories\AddNoteToSavedTask;
use App\Repositories\DayPlanRepositories\GetPlanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SavedTask2Repository;
use App\Http\Controllers\Services\HashCodeService;
use App\Http\Controllers\Services\AddPlanService;
use App\Repositories\DayPlanRepositories\CreateDayPlanRepository;
use App\Http\Controllers\Services\NotesService;
use App\Http\Controllers\Services\DataTransformationService;
use App\Http\Controllers\Services\EstimationService;
use App\Models\Tasks;
use Illuminate\Http\Response;

class MainController
{
    private $savedTaskRepository       = null;
    private $savedTaskService          = null;
    private $planService               = null;
    private $dayPlan                   = null;
    private $notesService              = null;
    private $notesRepository           = null;
    private $currentPlanInfo           = null;
    private $getDayPlanService         = null;
    private $dataTransformationService = null;
    private $estimationService         = null;

    public function __construct(SavedTask2Repository $taskRepository, HashCodeService $codeService,
                                AddPlanService $addPlanService,
                                CreateDayPlanRepository $createDayPlanRepository,
                                NotesService $notesService,
                                AddNoteToSavedTask $addNoteToSavedTask,
                                GetPlanRepository $getPlanRepository,
                                GetDayPlanService $getDayPlanService,
                                DataTransformationService $dataTransformationService,
                                EstimationService $estimationService)
    {
        $this->savedTaskRepository       = $taskRepository;
        $this->savedTaskService          = $codeService;
        $this->planService               = $addPlanService;
        $this->dayPlan                   = $createDayPlanRepository;
        $this->notesService              = $notesService;
        $this->notesRepository           = $addNoteToSavedTask;
        $this->currentPlanInfo           = $getPlanRepository;
        $this->getDayPlanService         = $getDayPlanService;
        $this->dataTransformationService = $dataTransformationService;
        $this->estimationService         = $estimationService;
    }

    public function addHashCode(Request $request)
    {
        $params = [];
        $params['hash_code']    = $request->input('hash');
        $params['user_id']      = Auth::id();
        $params['task_name']    = $request->input('taskName');
        $params['time']         = $request->input('time');
        $params['type']         = $request->input('type');
        $params['priority']     = $request->input('priority');
        $params['details']      = $request->input('details');
        $params['note']         = $request->input('notes');

        $flag = $this->savedTaskService->checkNewHashCode($params['hash_code']);
        if($flag){
            $transformData = $this->savedTaskService->transformDataForDb($params);
            $this->savedTaskRepository->saveNewHashCode($transformData);
            $response = $this->notesService->addNoteForSavedTask($params);
            if($response){
                $this->notesRepository->addSavedNote($params);
            }
        }
    }

    public function getSavedTasks()
    {
        $id = Auth::id();
        $hashCodes = $this->savedTaskRepository->getUserHashCodes($id);

        return response()->json([
            'id' => $id,
            'hash_codes' => $hashCodes,
        ]);//
    }

    public function getSavedTaskByHashCode(Request $request)
    {
        $hash_code = $request->get('hash_code');
        $params = ['id' => '', 'hash_code' => ''];
        $finalResult = [];
        if($hash_code){
            $params['id'] = Auth::id();
            $params['hash_code'] = $hash_code;
            $savedTask = $this->savedTaskRepository->getSavedTaskByHashCode($params);
            foreach ($savedTask as $val){
                foreach ($val as $i => $v){
                    $finalResult[] = $val->$i;
                }
            }
        }

        return response()->json($finalResult);//
    }

    public function addPlan(Request $request)
    {
        $data = $request->json()->all();
        $response = $this->planService->checkPlan($data);
        $responseArray = json_decode($response->content());
        if($responseArray->status == 'success') {

            $responseArrayAsArray["status"]  = $responseArray->status;

            $responseArray = $this->dayPlan->createDayPlan($data);
            $params        = ["id" => Auth::id(),"date" => Carbon::today()->toDateString()];
            $planForDay = $this->currentPlanInfo->getLastDayPlan($params); //получаю задания для составленного плана на день

            $jsonPlanForDay = $planForDay;
            $finalResponseArray = [
                "plan" => $jsonPlanForDay,
                "status" => "success",
                "message" => 'Plan has been successfully created! We wish you to realize conceived :) '
            ];

            return $finalResponseArray;
        }else{
            $response = response()->json($responseArray);

            return $response;//недостаточно заданий в плане
        }
    }

    public function getCreatedPlanIfExists()
    {
        $data = [
            "id"      => Auth::id(),
            "date"    => Carbon::today()
        ];
        $createdDayPlan = ($this->getDayPlanService->getPlan($data));//plan which has been already created if it exists

        if($createdDayPlan){
            $transformData  = ($this->dataTransformationService->transformData($createdDayPlan));

            return json_encode($transformData, JSON_UNESCAPED_UNICODE);
        }

        return response()->json("");
    }

    //---------------Estimation of tasks-----------------
    /**
     * I am waiting: {own_mark: <>, comment: "" }
     */
    public function estimateDay(Request $request)
    {
        $data = [
            "user_id"  => Auth::id(),
            "date"     => Carbon::today()->toDateString(),
            "own_mark" => $request->get('own_mark'),
            "comment"  => $request->get('comment'),
            "action"   => '2', //it means that user try to finish day plan
        ];
        $data = $this->estimationService->handleEstimationRequest($data);
        //to be continued..
    }

    /**
     * I am waiting: {task_id: <id>, mark: <>, details: "", note: "" }
     */
    public function estimateTask(Request $request)
    {
        //"is_ready" => ($request->get('is_ready')) ? ,
        $data = [
            "id"       => $request->get('task_id'),
            "details"  => $request->get('details'),
            "mark"     => $request->get('mark'),
            "note"     => $request->get('note'),
            "action"   => '1', //it means that user try to estimate one task
        ];
        //die(var_dump($data));
        $checkedData = $this->estimationService->handleEstimationRequest($data);
        //Tasks::whereId($data['id'])->update($checkedData); //DELETE THIS LINE! I DO IT WITH ESTIMATETASKREPOSITORY;

        $params        = ["id" => Auth::id(),"date" => Carbon::today()->toDateString()];
        $planForDay = $this->currentPlanInfo->getLastDayPlan($params); //получаю задания для составленного плана на день

        return json_encode($planForDay, JSON_UNESCAPED_UNICODE);//json  с обновленными данными!
        //to be continued..
    }

    /*Stat lib: https://github.com/stefanzweifel/laravel-stats*/
}
