<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 22.06.2021
 * Time: 14:38
 */
namespace App\Http\Controllers\Services;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Repositories\DayPlanRepositories\GetPlanRepository;

class AddPlanService
{

    private $getPlanRepository = null;

    public function __construct(GetPlanRepository $getPlanRepository)
    {
        $this->getPlanRepository = $getPlanRepository;
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
            'message' => 'Invalid day plan! Too few tasks! It has to be 2 or more required tasks.'
        ]);
    }

    private function checkTask($task)
    {
        $task = $this->getNumValuesOfStrValues($task);
        $flag["taskName"] = $this->checkName(isset($task['taskName'])  ? $task['taskName']  : '');
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
                case 0:
                    if($taskQuantity > 1){
                        /* Check quantity of required tasks. In this case it has to be more than 1! */
                        $i = 0;
                        array_filter($data['plan'], function ($v) use(&$i){
                            if($this->getNumValuesOfStrValues( $v )['type'] == 4 ){
                                $i += 1;
                            }
                        });
                        if($i > 1){
                            return true;
                        }

                        return false;
                    }
                    return false;
                case 1:
                    if($taskQuantity == 1){
                        return true;
                    }
                    return false;
                case 2:
                    if($taskQuantity == 0){
                        return true;
                    }
                    return false;
                case 3:
                    if($taskQuantity == 0){
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

    private function checkName($task)
    {
        $task = trim($task);
        if( strlen($task) > 3 && (strlen($task) < 255) ){
            return true;
        }

        return false;
    }

    private function checkDetails($task)
    {
        if( strlen($task) < 256){
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