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
use App\Repositories\EstimationRepository;
use App\Models\Tasks;
use Illuminate\Support\Facades\DB;
/* Dependencies for notifications */
use Thread;
use App\Notifications\UserNotification;
/* end */

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
    private $taskModel                 = null;
    private $estimationRepository      = null;
    private $userNotification          = null;

    public function __construct(SavedTask2Repository $taskRepository, HashCodeService $codeService,
                                AddPlanService $addPlanService,
                                CreateDayPlanRepository $createDayPlanRepository,
                                NotesService $notesService,
                                AddNoteToSavedTask $addNoteToSavedTask,
                                GetPlanRepository $getPlanRepository,
                                GetDayPlanService $getDayPlanService,
                                DataTransformationService $dataTransformationService,
                                EstimationService $estimationService,
                                EstimationRepository $estimationRepository,
                                Tasks $tasks,
                                UserNotification $userNotification)
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
        $this->estimationRepository      = $estimationRepository;
        $this->taskModel                 = $tasks;
        $this->userNotification          = $userNotification;
    }

    public function addHashCode(Request $request)
    {
        $params = [];
        $taskName = $request->input('taskName');
        $params['hash_code']    = $request->input('hash'); //hashCode
        $params['user_id']      = Auth::id();
        $params['task_name']    = ($taskName) ? $request->input('taskName') : $request->input('name');
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
        //die(var_dump($data));
        $response = $this->planService->checkPlan($data); //проблема здесь
        $responseArray = json_decode($response->content());
        if($responseArray->status == 'success') {

            $responseArrayAsArray["status"]  = $responseArray->status;
            /*This is for creating weekend*/
            if($this->planService->getTransformWeekendPlan()){ //That is a shame and I apologise for this ): This code must be modified.But later
                $data = $this->planService->getTransformWeekendPlan();
            }
            $responseArray = $this->dayPlan->createDayPlan($data);
            //die(var_dump($responseArray));

            /*Logic after adding plan in DB*/
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

        return "";
    }

    /*This method will execute for the card wich displays final information of the day */
    public function getClosedDayInfo()
    {
        $data = [
            "id"      => Auth::id(),
            "date"    => Carbon::today()
        ];

        //Here I would return json with day final info (final_estimation etc)
        $closedDayPlanInfo = $this->estimationRepository->getFinalInfoForTheDay($data);

        return json_encode($closedDayPlanInfo, JSON_UNESCAPED_UNICODE);
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
            "mark"     => $request->get('ownMark'),
            "comment"  => $request->get('comment'),
            "action"   => '2', //it means that user try to finish day plan
        ];
        $response = $this->estimationService->handleEstimationRequest($data);

        return response()->json($response); //comment
    }

    /**
     * I am waiting: {task_id: <id>, mark: <>, details: "", note: "" }
     */
    public function estimateTask(Request $request)
    {
        $isReady = ($request->get('is_ready'));
        $isReady = ( ($isReady) ? 99 : 50);
        $data = [
            "id"       => $request->get('task_id'),
            "details"  => $request->get('details'),
            "mark"     => $request->get('mark'),
            "is_ready" => $isReady,
            "note"     => $request->get('note'),
            "action"   => '1', //it means that user try to estimate one task
        ];
        $checkedData = $this->estimationService->handleEstimationRequest($data);
        if($checkedData){
            $params        = ["id" => Auth::id(),"date" => Carbon::today()->toDateString()];
            $planForDay = $this->currentPlanInfo->getLastDayPlan($params); //получаю задания для составленного плана на день

            //return json_encode($planForDay, JSON_UNESCAPED_UNICODE);//json  с обновленными данными!
            return json_encode("{status: success, message: 'Task has been updated.'}", JSON_UNESCAPED_UNICODE);
        }

        return json_encode("{status: error, message: 'Error during estimation.'}", JSON_UNESCAPED_UNICODE);
    }

    /*
     * For adding job/task after creation of day plan
     * {"hash_code":<string>, "name": <string>, "type": <string>, "priority": <int>, "time": <string>}*/
    public function addJob(Request $request)
    {
        $hash = $request->get('hash_code'); //hashCode
        $hash = (isset($hash)) ? $request->get('hash_code') : '#';
        $data = [
            "hash"     => $hash,
            "taskName" => $request->get('name'),
            "type"     => $request->get('type'),
            "priority" => $request->get('priority'),
            "time"     => $request->get('time'),
            "notes"    => '',
        ];
        $response = $this->planService->checkExtraJob($data);
        $data = $this->dataTransformationService->getNumValuesOfStrValues($data);
        if($response['status'] == 'success'){
            $dataForTasks = [
                "timetable_id" => $this->getLastTimetableId(),
                "hash_code"    => $hash,
                "task_name"    => $data['taskName'],
                "type"         => $data['type'],
                "priority"     => $data['priority'],
                "time"         => $data['time'],
                "mark"         => -1,
                "created_at"   => DB::raw('CURRENT_TIMESTAMP(0)'),
                "updated_at"   => DB::raw('CURRENT_TIMESTAMP(0)')
            ];
            //It would be better if I make it like transaction
            Tasks::insert($dataForTasks);
            $response['taskId'] = DB::getPdo()->lastInsertId();
        }

        return $response;
    }

    /*
     * Method for getting notifications */
    public function getNotifications(Request $request, Thread $thread)
    {
        \auth()->user()->notify($this->userNotification);
    }

    private function getLastTimetableId()
    {
        $params          = ["id" => Auth::id(),"date" => Carbon::today()->toDateString()];
        $lastTimeTableId = $this->currentPlanInfo->getLastTimetableId($params);

        return $lastTimeTableId;
    }
}
