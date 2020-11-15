<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 11.06.2020
 * Time: 13:07
 */

namespace App\Http\Controllers\Services\DataProcessServices;


class TaskProcessService {

    private $unProcessedData          = [];
    private $requiredTasks            = [];
    private $nonRequiredTasks         = [];
    private $status                   = [];
    private $mergeTasks               = [];
    private $addedTask                = [];
    private $validateExtraTaskService = null;

    public function __construct(\App\Http\Controllers\Services\ValidateExtraTaskServices\ValidateExtraTaskService $validateExtraTaskService)
    {
        $this->validateExtraTaskService = $validateExtraTaskService;
    }

    public function startProcess(array $data)
    {
        //die(print_r($data)); //right data
        $this->unProcessedData  = $data; //необработанные данные нового задания есть

        if(!isset($this->unProcessedData['added'])) {
            $this->requiredTasks = $this->processRequiredTasks();
            $this->nonRequiredTasks = $this->processNonRequiredTasks();
            $this->status           = $this->getStatus();
            $this->mergeTasks[] = $this->requiredTasks;
            $this->mergeTasks[] = $this->nonRequiredTasks;
            $this->mergeTasks[] = $this->getStatus();

            return $this->mergeTasks;
        }else{
           $this->addedTask = $this->processedAddedTask();
            if (is_array($this->addedTask)) {
                return $this->addedTask; //правильно
            }
        }

        return false;
    }

    private function processRequiredTasks()
    {
        $requiredTasks = [];
        foreach($this->unProcessedData as $tasks){
            if(is_array($tasks)) {
                foreach ($tasks as $task) {
                    if (count($task) > 2) {
                        if ($task[3] == '2') {
                            $requiredTasks[] = $task;
                        }
                    }
                }
            }
        }

        return $requiredTasks;
    }

    private function processNonRequiredTasks()
    {
        $nonRequiredTasks = [];
        foreach($this->unProcessedData as $tasks){
            if(is_array($tasks)) {
                foreach ($tasks as $task) {
                    if (count($task) > 2) {
                        if ($task[3] == '1') {
                            $nonRequiredTasks[] = $task;
                        }
                    }
                }
            }
        }

        return $nonRequiredTasks;
    }

    private function getStatus()
    {
        $status = [];
        foreach ($this->unProcessedData as $tasks) {
            if (is_array($tasks)) {
                foreach ($tasks as $task) {
                    if (count($task) == 2) {
                        $status[] = $task[1];
                    }
                }
            }
        }

        return $status;
    }

    private function processedAddedTask()
    {
        $result = $this->validateExtraTaskService->check($this->unProcessedData);//или задание или false

        return $result;
    }
}

/*Data Loaded: Array
(
    [list] => Array
        (
            [0] => Array
                (
                    [0] => task1
                    [1] => 01:00
                    [2] => com1
                    [3] => 2
                )

            [1] => Array
                (
                    [0] => task2
                    [1] => 02:00
                    [2] => com2
                    [3] => 2
                )

            [2] => Array
                (
                    [0] => non-task1
                    [1] => 00:30
                    [2] => com3
                    [3] => 1
                )

            [3] => Array
                (
                    [0] =>
                    [1] => Ред
                )

        )

    [_token] => {{csrf_token()}}
)*/