<?php
namespace App\Http\Controllers\Services;


class HistTransformationService
{
    /*
    * Transform -1 в -
    * 99 for tasks in "OK"
    */
    public function transformHistResponse(array $data)
    {
        foreach ($data['plans'] as $plan) {
            foreach ($plan['tasks'] as $task) {
                if ($task->mark == -1) {
                    $task->mark = "-";
                } else {
                    $task->mark = $task->mark . "%";
                }
                if (in_array($task->type, [1, 2])) {
                    $task->mark = ($task->mark == 99) ? 'OK': '-';
                }
            }
        }
       
    }
}