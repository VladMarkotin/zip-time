<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 10.05.2020
 * Time: 13:06
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Services\EstimationServices\EstimateService;
use App\Http\Controllers\Services\PlanServices\CreateTimeTableService as PlanService;
use App\Http\Controllers\Services\ValidateEmergencyCauseService\ValidateEmergencyCauseService;
use App\Http\Controllers\Services\ValidateMarkService\ValidateMarkService;
use Controllers\Services\PlanServices\DayInfoService;
use Controllers\Services\PlanServices\EmergencyCallService;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\DataProcessServices\TaskProcessService as TaskProcessService;
use App\Http\Controllers\Services\ValidateTaskServices\CheckTaskService as CheckTaskService;
use Controllers\Services\PlanServices\AddTaskService;

class PlanController extends Controller
{
    private $planService;
    private $taskProcessService;
    private $validator;
    private $dayInfoService;
    private $validateMarkService;
    private $estimateService;
    private $addTaskService;
    private $validateEmergencyService;
    private $emergencyCallService;

    public function __construct(PlanService $planService,
                                TaskProcessService $taskProcess,
                                CheckTaskService $validator,
                                DayInfoService $dayInfoService,
                                ValidateMarkService $validateMarkService,
                                EstimateService $estimateService,
                                AddTaskService $addTaskService,
                                ValidateEmergencyCauseService $validateEmergencyCauseService,
                                EmergencyCallService $emergencyCallService)
    {
        $this->planService              = $planService;
        $this->taskProcessService       = $taskProcess;
        $this->validator                = $validator;
        $this->dayInfoService           = $dayInfoService;
        $this->validateMarkService      = $validateMarkService;
        $this->estimateService          = $estimateService;
        $this->addTaskService           = $addTaskService;
        $this->validateEmergencyService = $validateEmergencyCauseService;
        $this->emergencyCallService     = $emergencyCallService;
    }

    public function index(Request $request)
    {
        $i = 0;
        $fullData = json_decode($request->getContent(),true);
        $dayPlan = $this->taskProcessService->startProcess($fullData);

        $result = $this->validator->validate($dayPlan);
        while($i < count($result)){
            if($result[$i] !== "0"){
               return response()->json([
                   'message' => "Задания не прошли валидацию! Перепроверьте введенные данные.",
                   "decoration" => "alert alert-danger"
               ]);
            }
            $i++;
        }
        $this->dayInfoService->createDay($dayPlan[2][0]);   //вносим в бд данные о текущем дне.Передаем статус дня
        $this->planService->create($dayPlan); //пишем в базу составленный план

        return response()->json(['message' => "План на день успешно сформирован. Желаю удачи в работе!",
                                 "decoration" => "alert alert-success"
        ]);

    }

    public function estimate(Request $request)
    {
        $fullData = json_decode($request->getContent(),true);
        $answer = $this->validateMarkService->validate($fullData);
        if(is_object( $answer)){
            return response()->json([
                'message'    => "Произошла ошибка при выставлении оценкок!",
                "decoration" => "alert alert-danger"
                ]);
        }
        else {
            $this->estimateService->estimate($fullData);

            return response()->json([
                'message'    => "Оценка обновлена!",
                "decoration" => "alert alert-success"
            ]);
        }
    }

    public function addWork(Request $request)
    {
        $fullData = json_decode($request->getContent(),true);
        $result = $this->taskProcessService->startProcess($fullData);
        if(!$result){
            return response()->json([
                'message' => "Задания не прошли валидацию! Перепроверьте введенные данные.",
                "decoration" => "alert alert-danger"
            ]);
        }
        /*Тут код добавления задания в базу*/
        $this->addTaskService->create($result);

        return response()->json([
            'message' => "Задание успешно добавлено!",
            "decoration" => "alert alert-success"
        ]);
    }

    public function emergencyCall(Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $answers = $this->validateEmergencyService->check($data);
        foreach ($answers as $a){
            if(!$a){
                return response()->json([
                    'message' => "Причина не прошла валидацию!Может она и не такая уж весомая, а?)",
                    "decoration" => "alert alert-danger"
                ]);
            }
        }
        $response = $this->emergencyCallService->emergencyCall($data);
        if($response){
            return response()->json([
                'message' => "Экстренный режим активирован! Сожалеем,что у вас не получилось выполнить план :(",
                "decoration" => "alert alert-success"
            ]);
        }
        return response()->json([
            'message' => "Не удалось активировать экстренный режим!",
            "decoration" => "alert alert-danger"
        ]);


    }
}