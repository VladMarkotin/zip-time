<?php
namespace App\Http\Controllers\Services\IndexStatServices;


use App\Models\TimetableModel;
use App\Models\Tasks;

class IndexStatService
{
    public function countStatIndex()
    {
        $_this = $this;
        $created = function () use ($_this) {
           return  $_this->countPlans();
        };
        $completedPlans = function () use ($_this) {
            return  $_this->countPlans();
        };
        $weekends = function () use ($_this) {
            return  $_this->countPlans(1);
        };
        $completedTasks = function () use ($_this) {
            return $_this->countCompletedTasks();
        };
        $completedDays = function () use ($_this) {
            return $_this->countPlans(3);
        };
        $statIndex = [
            'created'   => $created(),
            'completed_days'  => $completedDays(),
            'weekends' => $weekends(),
            'completed_tasks' => $completedTasks(),
        ];

        return ($statIndex);
    }

    private function countPlans($type = null) //according day_status index
    {
        if (!$type) {
            $plans = TimetableModel::whereIn('day_status', [-1, 0, 1,2,3])->get()->count();
            
            return $plans; 
        } else if ($type == 1) {
            $plans = TimetableModel::where('day_status', 1)->get()->count();
            
            return $plans;
        }
        $plans = (TimetableModel::whereIn('day_status', [1, 3])->get()->count());

        return $plans;  
    }

    private function countCompletedTasks()
    {
        $amount = Tasks::where('mark','<>',-1)
        ->count();

        return $amount;
    }
}