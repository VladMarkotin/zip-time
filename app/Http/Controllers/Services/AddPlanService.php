<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 22.06.2021
 * Time: 14:38
 */
namespace App\Http\Controllers\Services;


use App\Models\DefaultConfigs;
use Illuminate\Support\Carbon;
use App\Models\PersonalConfigs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Repositories\DayPlanRepositories\GetPlanRepository;
use App\Http\Controllers\Services\DataTransformationService;

class AddPlanService
{

    private $minTaskQuantity;
    private $getPlanRepository         = null;
    private $dataTransformationService = null;
    private $transformWeekendData      = null; //here will store transform data for weekend.You have to get it when create day plan for weekend

    public function __construct(GetPlanRepository $getPlanRepository,
                                DataTransformationService $dataTransformationService)
    {
        $this->getPlanRepository         = $getPlanRepository;
        $this->dataTransformationService = $dataTransformationService;
    }

    public function checkPlan(array $data)
    {
        $flags = [];
        if($this->hasPlanAlreadyBeenCreated()){
            return response()->json([
                'status'=> "error",
                'message' => "Plan has already been created"
            ]);
        }
//        Here I need an ex6tra condition for weekend
        if($data['day_status'] == 1){
            //die(var_dump($data));//good
            $transformData = $this->dataTransformationService->transformDataForWeekendRequest($data);//Not a $data['plan']!!!
            $this->transformWeekendData = $transformData; //this all cause I need to save tranform data for weekend
            $this->transformWeekendData['day_status'] = 1;

            return response()->json(['status' => 'success']);
        }
        if($this->checkRequiredTaskQuantity($data)) {
            //отсюда буду вызывать метод checkTask для каждого заданиия
            foreach ($data['plan'] as $v) {
                $flags[] = $this->checkTask($v);
            }
            foreach ($flags as $v) {
                foreach ($v as $k => $val) {
                    if (!$val) return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid day plan! Error has happend with ' . $k
                    ]);
                }
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json([
            'status' => 'error',
            'message' => "Invalid day plan! Too few tasks! It has to be $this->minTaskQuantity or more required jobs."
        ]);
    }

    public function checkExtraJob(array $data)
    {
        ;
        $flags[] = $this->checkTask($data);
        foreach ($flags as $v) {
            foreach ($v as $k => $val) {
                if (!$val) return [
                    'status' => 'fail',
                    'message' => 'Invalid day plan! Error has happend with ' . $k
                ];
            }
        }
        $response = [
            'status' => 'success',
            'message' => 'Task has been successfully added.'
        ];

        return $response;
    }

    public function getTransformWeekendPlan()
    {
        return $this->transformWeekendData;
    }

    private function checkTask($task)
    {
        $task = $this->getNumValuesOfStrValues($task);
        $flag["taskName"] = $this->checkName(isset($task['taskName'])  ? $task['taskName']  : '')['flag'];
        $flag["details"] = $this->checkDetails(isset($task['details']) ? $task['details']   : '');
        $flag["time"] = $this->checkTime(isset($task['time'])          ? $task['time']      : '');
        $flag["notes"] = $this->checkNote(isset($task['notes'])        ? $task['notes']     : '');

        return $flag;
    }

    private function checkRequiredTaskQuantity(array $data)
    {
        if(is_array($data['plan']) ) {
            $taskQuantity = count($data['plan']);
            switch ($data["day_status"]) {
                case 2: //Work Day
                    $pesrConfigMinTaskQuant =json_decode( PersonalConfigs::getConfigs()->config_data)
                    ->rules[0]->minRequiredTaskQuantity;
                    $defConfigMinTaskQuant = json_decode(DefaultConfigs::getConfigs()[1]->config_data)->rules[0]->minRequiredTaskQuantity;

                    $this->minTaskQuantity = !empty($pesrConfigMinTaskQuant) ? $pesrConfigMinTaskQuant : $defConfigMinTaskQuant;
                    
                    if($taskQuantity >=  $this->minTaskQuantity){ //
                        /* Check quantity of required tasks. In this case it has to be more than 1! */
                        $i = 0;
                        array_filter($data['plan'], function ($v) use(&$i){
                            if($this->getNumValuesOfStrValues( $v )['type'] == 4 ){
                                $i += 1;
                            }
                        });
                        if($i >= $this->minTaskQuantity){
                            return true;
                        }

                        return false;
                    }
                    return false;
                case 1: //Weekend
                    if($taskQuantity > 0){
                        return true;
                    }
                    return false;
            }
        }

        return 0;
    }

    /*Преобразую здесь строковые значения в плане на день (e.g 'required task') в код, который пишется в базу (e.g 4)*/
    public function getNumValuesOfStrValues($task)
    {
        switch($task['type']){
            case 'required job'    : $task['type'] = 4;
                return $task;
            case 'non required job': $task['type'] = 3;
                return $task;
            case 'required task'   : $task['type'] = 2;
                return $task;
            case 'task'            : $task['type'] = 1;
                return $task;
            case 'reminder'        : $task['type'] = 0;
                return $task;
        }

        return $task;
    }

    public function checkName($task)
    {
        if( strlen($task) > 3 && (strlen($task) < 255) ){
            return ['flag' => true,];
        }

        $transformedTask = strlen($task) < 30 ? $task :  substr($task, 0, 29) . '...'; 

        return [
            'flag' => false, 
            'message' => "The name of your task must contain between 4 and 254 characters, inclusive. Unable to use task name: $transformedTask"
        ];
    }

    private function checkDetails($task)
    {
        if( strlen($task) < 1500){
            return true;
        }

        return false;
    }

    private function checkTime($time)
    {
        if(preg_match("/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/", $time)){
            return true;
        }

        return false;
    }

    private function checkNote($note)
    {
        $note = trim($note);
        if( strlen($note) < 256){
            return true;
        }

        return false;
    }

    private function hasPlanAlreadyBeenCreated()
    {
        $params['date'] = Carbon::today()->toDateString();
        $params['id'] = Auth::id();
        $response = $this->getPlanRepository->getDateOfLastTimetable($params);

        return $response;
    }

} 