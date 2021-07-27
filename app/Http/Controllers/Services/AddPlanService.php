<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 22.06.2021
 * Time: 14:38
 */
namespace App\Http\Controllers\Services;


use Illuminate\Support\Facades\Auth;

class AddPlanService
{
    public function __construct()
    {

    }

    public function checkPlan(array $data)
    {
        $flags = [];
        //отсюда буду вызывать метод checkTask для каждого заданиия
        foreach ($data as &$v){
            $v = $this->checkTask($v);

        }
        //Наверноне надо выполнять цикл до тех пор пока checkTask() возвращает массив, а не false
        die(print_r($data));
    }

    private function checkTask($task)
    {
        $flags = [];
        /*В зависимости от типа задания, буду вызывать соотв проверку*/
        $task = $this->getNumValuesOfStrValues($task);
        $flag[] = $this->checkName($task['taskName']);
        $flag[] = $this->checkDetails($task['details']);
        $flag[] = $this->checkDetails($task['time']);
        //if($flag)
        return $task;
    }

    private function checkRequiredTaskQuantity()
    {

    }

    /*Преобразую здесь строковые значения в плане на день (e.g 'required task') в код, который пишется в базу (e.g 4)*/
    private function getNumValuesOfStrValues($task)
    {
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
        if( strlen($task) > 3){
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

    private function checkTime($task)
    {
        /* Пока не знаю как проверять
         * if( strlen($task) < 256){
            return true;
        }*/

        return true;
    }

} 