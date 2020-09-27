<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 14.06.2020
 * Time: 8:43
 */

namespace App\Http\Controllers\Services\ValidateTaskServices;


use Illuminate\Support\Facades\Validator as Validator;

class CheckTaskService
{
    public function validate(array $tasks)
    {
        //die(print_r($tasks));
        $result[] = $this->checkRequiredTasks($tasks[0]);
        $result[] = $this->checkNonRequiredTasks($tasks[1]);

        return $result;
    }

    private function checkRequiredTasks(array $requiredTasks)
    {
        $validator = Validator::make(
            $requiredTasks,
            ['*.0' => 'required|min:3', '*.2' => 'nullable|min:3']
        );
        if($validator->fails()){
            return $validator->errors();
        }

        return "0";
    }

    private function checkNonRequiredTasks(array $nonRequiredTasks)
    {
        $validator = Validator::make(
            $nonRequiredTasks,
            ['*.0' => 'max:30', '*.2' => 'nullable|max:30']
        );
        if($validator->fails()){
            return $validator->errors();
        }

        return "0";
    }

    private function checkExtraTask(array $extraTask)
    {
        return "0";
    }

}

/*
 *  Array
(
    [0] => Array
        (
            [0] => task1
            [1] => 02:00
            [2] => com1
            [3] => 2
        )

    [1] => Array
        (
            [0] => task2
            [1] => 01:00
            [2] => com2
            [3] => 2
        )

)
 */

/*
 * Array
(
    [0] => Array
        (
            [0] => task1
            [1] => 02:00
            [2] => com1
            [3] => 2
        )

    [1] => Array
        (
            [0] => task2
            [1] => 01:00
            [2] => com2
            [3] => 2
        )

)
1
 */