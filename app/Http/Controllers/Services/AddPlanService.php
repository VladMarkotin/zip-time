<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 22.06.2021
 * Time: 14:38
 */
namespace App\Http\Controllers\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AddPlanService
{
    public function __construct()
    {

    }

    public function checkPlan(array $data)
    {
        $flags = [];
        //die(var_dump($data));
        //отсюда буду вызывать метод checkTask для каждого заданиия
        foreach ($data['plan'] as $v){
            $flags[] = $this->checkTask($v);
        }
        foreach($flags as $v){
            foreach($v as $k => $val) {
                if (!$val) return response()->json(['status' => 'error', 'message' => 'Invalid day plan! Error has
                    happend with '.$k]);
            }
        }

        return response()->json(['status' => 'success', 'message' => '']);
    }

    private function checkTask($task)
    {
        $flags = [];
        //die(var_dump($task));
        /*В зависимости от типа задания, буду вызывать соотв проверку*/
        $task = $this->getNumValuesOfStrValues($task);
        $flag["taskName"] = $this->checkName(isset($task['taskName']) ? $task['taskName']: '');
        $flag["details"] = $this->checkDetails(isset($task['details']) ? $task['details']   : '');
        $flag["time"] = $this->checkTime(isset($task['time'])       ? $task['time'] : '');
        $flag["notes"] = $this->checkNote(isset($task['notes'])      ? $task['notes'] : '');

        return $flag;
    }

    private function checkRequiredTaskQuantity()
    {

    }

    /*Преобразую здесь строковые значения в плане на день (e.g 'required task') в код, который пишется в базу (e.g 4)*/
    public function getNumValuesOfStrValues($task)
    {
        //die(var_dump($task));
        switch($task['type']){
            case 'required job': $task['type'] = 4;
                return $task;
            case 'non required job': $task['type'] = 3;
                return $task;
            case 'required task': $task['type'] = 2;
                return $task;
            case 'task': $task['type'] = 1;
                return $task;
            case 'reminder': $task['type'] = 0;
                return $task;
        }

        return $task;
    }

    private function checkName($task)
    {
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
        if( strlen($note) < 256){
            return true;
        }

        return false;
    }

} 