<?php
namespace App\Http\Controllers\Services;

use Illuminate\Support\Carbon;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;


class HistTransformationService
{
    /*
    * Transform -1 в -
    * 99 for tasks in "OK"
    */
    public function transformHistResponse(array $data, string $todayDate)
    {
        foreach ($data['plans'] as $planDate => &$plan) {
            $plan["isDayPassed"] = !GeneralHelper::checkIfDateIsLater($planDate, $todayDate);
            if ($plan["isDayPassed"]) {
                foreach ($plan['tasks'] as $task) {
                    if ($task->mark == -1) {
                        $task->mark = "-";
                    } else {
                        $task->mark = $task->mark . "%";
                    }
                    if (in_array($task->type, [1, 2])) {
                        $task->mark = ((int) $task->mark == 99) ? 'OK': '-';
                    }
                }
            }
        }
        return $data;
    }
}