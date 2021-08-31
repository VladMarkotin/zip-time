<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 29.05.2021
 * Time: 7:52
 */

namespace App\Http\Controllers;


use App\Repositories\DayPlanRepositories\AddNoteToSavedTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SavedTask2Repository;
use App\Http\Controllers\Services\HashCodeService;
use App\Http\Controllers\Services\AddPlanService;
use App\Repositories\DayPlanRepositories\CreateDayPlanRepository;
use App\Http\Controllers\Services\NotesService;
use Illuminate\Http\Response;

class MainController
{
    private $savedTaskRepository = null;
    private $savedTaskService    = null;
    private $planService         = null;
    private $dayPlan             = null;
    private $notesService        = null;
    private $notesRepository     = null;

    public function __construct(SavedTask2Repository $taskRepository, HashCodeService $codeService,
                                AddPlanService $addPlanService,
                                CreateDayPlanRepository $createDayPlanRepository,
                                NotesService $notesService,
                                AddNoteToSavedTask $addNoteToSavedTask)
    {
        $this->savedTaskRepository = $taskRepository;
        $this->savedTaskService    = $codeService;
        $this->planService         = $addPlanService;
        $this->dayPlan             = $createDayPlanRepository;
        $this->notesService        = $notesService;
        $this->notesRepository     = $addNoteToSavedTask;
    }

    public function addHashCode(Request $request)
    {
        $params = [];
        $params['hash_code']         = $request->input('hash');
        $params['user_id']      = Auth::id();
        $params['task_name']     = $request->input('taskName');
        $params['time']         = $request->input('time');
        $params['type']         = $request->input('type');
        $params['priority']     = $request->input('priority');
        $params['details']      = $request->input('details');
        $params['note']        = $request->input('notes');

        $flag = $this->savedTaskService->checkNewHashCode($params['hash_code']);
        if($flag){
            $transformData = $this->savedTaskService->transformDataForDb($params);
            $this->savedTaskRepository->saveNewHashCode($transformData);
            $response = $this->notesService->addNoteForSavedTask($params);
            if($response){
                $this->notesRepository->addSavedNote($params);
            }
        }
        //die(var_dump($flag));//ok
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
            $responseArray = $this->dayPlan->createDayPlan($data); //разобраться с проверкой
            //die(var_dump($responseArray->getData()));
            return response()->json($responseArray->getData());
        }else{
            return response()->json($responseArray->getData());//недостаточно заданий в плане
        }
    }
}
