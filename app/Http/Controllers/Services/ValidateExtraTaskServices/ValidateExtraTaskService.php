<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 23.08.2020
 * Time: 8:06
 */
namespace App\Http\Controllers\Services\ValidateExtraTaskServices;

class ValidateExtraTaskService
{

    public function check($unprocessedData)
    {
        $newTaskValidate = [];
        $newTaskValidate[] = $this->checkShortName($unprocessedData['shortName']);
        $newTaskValidate[] = $this->checkTime($unprocessedData['time']);
        $newTaskValidate[] = $this->checkNote($unprocessedData['note']);

        /*Array
        ( Результат проверки,если все правильно
            [0] => 0
            [1] => 0
            [2] => 0
        )*/

        foreach($newTaskValidate as $v){
            if($v != '0'){
                return false;
            }
        }
        //die("sfg"); right!
        return $unprocessedData;
    }

    private function checkShortName($shortName)
    {
        if(strlen($shortName) > 2){
            return '0';
        }

        return '1';
    }

    private function checkTime($time)
    {
        if(strlen($time)){
            return '0';
        }

        return '1';
    }

    private function checkNote($note)
    {
        if( (( strlen($note) >= 0) &&  strlen($note) < 255 )){
            return '0';
        }

        return '1';
    }
}

/*
 * Array
(
    [shortName] => ts
    [time] => 01:00
    [note] => test2
    [status] => Обязательное задание
    [added] => 1
)*/