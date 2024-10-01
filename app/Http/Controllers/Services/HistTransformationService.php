<?php
namespace App\Http\Controllers\Services;

use Illuminate\Support\Carbon;


class HistTransformationService
{
    /*
    * Transform -1 в -
    * 99 for tasks in "OK"
    */
    public function transformHistResponse(array $data, string $todayDate)
    {
        foreach ($data['plans'] as $planDate => &$plan) {
            $plan["isUpcomingDay"] = $this->checkIsBeforeToday($planDate, $todayDate);
            if ($plan["isUpcomingDay"]) {
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

    private function checkIsBeforeToday($planDate, $todayDate)
    {
        return Carbon::createFromFormat('Y-m-d', $planDate)->isBefore(Carbon::createFromFormat('Y-m-d', $todayDate));
    }
}