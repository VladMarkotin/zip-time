<?php
namespace App\Http\Controllers\Services\SubPlanServices;


use App\Models\SubPlan;

class SubPlanService
{
    private $subPlan = null;

    public function __construct(SubPlan $subPlan)
    {
        $this->subPlan = $subPlan;
    }

    public function countPercentOfCompletedWork(array $data)
    {
        $taskQuantity = $this->getTaskQuantity($data);
        $completedTaskQuantity = $this->completedTaskQuantity($data);
        $result =  ($taskQuantity) ? ($completedTaskQuantity / $taskQuantity) * 100 : null;

        return round($result, 2).'%';
    }

    private function getTaskQuantity(array $data)
    {
        $subPlanQuantity = SubPlan::where([['task_id', $data['task_id'] ] ])
        ->get()
        ->count();

        return $subPlanQuantity;
    }

    private function completedTaskQuantity(array $data)
    {
        $doneSubPlanQuantity = SubPlan::where([['task_id', $data['task_id'] ], ['is_ready', 1] ])
        ->get()->count();
        
        return $doneSubPlanQuantity;
    }
}