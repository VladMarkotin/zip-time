<?php
namespace App\Http\Controllers\Services\SubPlanServices;

use App\Models\SubPlan;
use App\Models\Tasks;
use App\Models\SavedTask;
use Auth;

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
        //die(var_dump($taskQuantity));
        $result =  ($taskQuantity) ? ($completedTaskQuantity / $taskQuantity) * 100 : null;

        return round($result, 2).'%';
    }

    public function getSavedTaskId(array $data)
    {
        $hashCode = Tasks::select('hash_code')->where('id', $data['task_id'])->get()->toArray();
        $savedTaskId = SavedTask::select('id')
        ->where('hash_code', $hashCode[0]['hash_code'])
        ->where('user_id', Auth::id())
        ->get()
        ->toArray();
        
        //die(var_dump($savedTaskId));
        if (count($savedTaskId)) {
            return ($savedTaskId[0]['id']);
        }

        return false;
    }

    private function getTaskQuantity(array $data)
    {
        //have to sum current subtasks and prev undone tasks
        $savedTaskId = SubPlan::select('saved_task_id')->where([['task_id', $data['task_id'] ] ])->get()->toArray()[0]['saved_task_id']; //вот это точно надо поправить

        if ($savedTaskId) {
            $subPlanQuantity = SubPlan::where([['saved_task_id', $savedTaskId ]])
            ->where('created_at', '>', date('Y-m-d').' 00:00:00')
            ->get()
            ->count();
        } else {
            $subPlanQuantity = SubPlan::where([['task_id', $data['task_id']]])
            ->where('created_at', '>', date('Y-m-d').' 00:00:00')
            ->get()
            ->count();
        }
        

        $prevUndoneSubPlan = SubPlan::where([['saved_task_id', $this->getSavedTaskId($data) ]])
        ->where('is_failed', 1)
        ->get()
        ->count();
        //die(var_dump($subPlanQuantity + $prevUndoneSubPlan));//+ $prevUndoneSubPlan

        return ($subPlanQuantity + $prevUndoneSubPlan);
    }

    private function completedTaskQuantity(array $data)
    {
        $doneSubPlanQuantity = SubPlan::where([['task_id', $data['task_id'] ], ['is_ready', 1] ])
        ->where('created_at', '>', date('Y-m-d').' 00:00:00')
        ->get()
        ->count();
        $prevDoneSubPlanQuantity = SubPlan::where([['saved_task_id', $this->getSavedTaskId($data) ]])
        ->where('is_failed', 1)
        ->where('is_ready', 1)
        ->get()
        ->count();
        //die(var_dump($prevDoneSubPlanQuantity));
        
        return ($prevDoneSubPlanQuantity + $doneSubPlanQuantity);
    }

    public function addIsFailedStatus()
    {
        $currentUserSavTaskId = SavedTask::select('id')
        ->where('user_id', Auth::id())
        ->get()
        ->toArray();

        $currentSubtasksId = SubPlan::select(['id'])
        ->where('is_ready', 0)
        ->where('created_at', '<', date('Y-m-d').' 00:00:00')
        ->where('is_failed', 0)
        ->whereIn('saved_task_id', $currentUserSavTaskId)
        ->get()
        ->toArray();

        if (count($currentSubtasksId)) {
            foreach($currentSubtasksId as $id) {
                SubPlan::whereId($id)->update(['is_failed' => 1]);
            };
        }

        return $currentUserSavTaskId;
    }

    public function removeCheckpointStatus($currentUserSavTaskId) {
        $currentSubtasksId = SubPlan::select(['id'])
        ->where('is_ready', 0)
        ->where('checkpoint', 1)
        ->where('created_at', '<', date('Y-m-d').' 00:00:00')
        ->whereIn('saved_task_id', $currentUserSavTaskId)
        ->get()
        ->toArray();

        if (count($currentSubtasksId)) {
            foreach($currentSubtasksId as $id) {
                SubPlan::whereId($id)->update(['checkpoint' => 0]);
            };
        }
    }
}