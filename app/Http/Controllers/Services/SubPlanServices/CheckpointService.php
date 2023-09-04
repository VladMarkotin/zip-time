<?php
namespace App\Http\Controllers\Services\SubPlanServices;


use App\Models\SubPlan;

class CheckpointService
{
    private $subPlan = null;

    public function __construct(SubPlan $subPlan)
    {
        $this->subPlan = $subPlan;
    }

    public function checkCheckpoints(array $data)
    {
        $unDoneSubPlan = SubPlan::where([['task_id', $data['task_id'] ], ['checkpoint', 1], ['is_ready', 0] ])
        ->get()->toArray();
        if (count($unDoneSubPlan) == 0) {
            return true;
        }

        return false;
    }
}