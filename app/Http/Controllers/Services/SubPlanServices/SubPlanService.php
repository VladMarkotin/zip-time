<?php
namespace App\Http\Controllers\Services\SubPlanServices;

use App\Models\SubPlan;
use App\Models\Tasks;
use App\Models\SavedTask;
use App\Models\User;
use Auth;

class SubPlanService
{
    private $subPlan         = null;
    private $currentUserTime = null;

    public function __construct(SubPlan $subPlan)
    {
        $this->subPlan = $subPlan;
    }

    public function countPercentOfCompletedWork(array $data)
    {   
        $this->currentUserTime = $this->getUserTime('Y-m-d');

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
        $currentUserTime = $this->currentUserTime;
        $savedTaskId = SubPlan::select('saved_task_id')->where([['task_id', $data['task_id'] ] ])->get()->toArray();

        if (count($savedTaskId)) {
            $savedTaskId = $savedTaskId[0]['saved_task_id'];
        }

        $getSubPlanQuantity = function($columnName, $columnVal, $currentUserTime) {
            $subPlanQuantity = SubPlan::where([[$columnName, $columnVal]])
            ->where('created_at', '>', $currentUserTime.' 00:00:00')
            ->get()
            ->count();

            return $subPlanQuantity;
        };

        $subPlanQuantity = $savedTaskId
            ? $getSubPlanQuantity('saved_task_id', $savedTaskId, $currentUserTime)
            : $getSubPlanQuantity('task_id', $data['task_id'], $currentUserTime);

        $prevUndoneSubPlan = SubPlan::where([['saved_task_id', $this->getSavedTaskId($data) ]])
        ->where('is_failed', 1)
        ->get()
        ->count();

        return ($subPlanQuantity + $prevUndoneSubPlan);
    }

    private function completedTaskQuantity(array $data)
    {
        $currentUserTime = $this->currentUserTime;
        $savedTaskId = SubPlan::select('saved_task_id')->where([['task_id', $data['task_id'] ] ])->get()->toArray();

        if (count($savedTaskId)) {
            $savedTaskId = $savedTaskId[0]['saved_task_id'];
        }

        $getDoneSubPlanQuantity = function($columnName, $columnVal, $currentUserTime) {
            $doneSubPlanQuantity = SubPlan::where([[$columnName, $columnVal]])
            ->where('is_ready', 1)
            ->where('created_at', '>', $currentUserTime.' 00:00:00')
            ->get()
            ->count();

            return $doneSubPlanQuantity;
        };

        $doneSubPlanQuantity = $savedTaskId 
            ? $getDoneSubPlanQuantity('saved_task_id', $savedTaskId, $currentUserTime)
            : $getDoneSubPlanQuantity('task_id', $data['task_id'], $currentUserTime);

        $prevDoneSubPlanQuantity = SubPlan::where([['saved_task_id', $this->getSavedTaskId($data) ]])
        ->where('is_failed', 1)
        ->where('is_ready', 1)
        ->get()
        ->count();
        
        return ($prevDoneSubPlanQuantity + $doneSubPlanQuantity);
    }

    public function getFailedSubtasks($savedTaskId)
    {
        $failedSubTasks = SubPlan::where('saved_task_id', $savedTaskId)
        ->where('is_failed', 1)
        ->get()
        ->toArray();  

        return $failedSubTasks;
    }

    public function addIsOldCompleatedStatus(Array $subPlan) {
        return array_map(function($detail) {
            $isOlDetail = $detail['created_at'] < ($this->getUserTime('Y-m-d') . ' 00:00:00');
            $isCompleatedDetail = empty($detail['is_failed']);

            $detail['is_old_compleated'] = $isOlDetail && $isCompleatedDetail;
            return $detail;
        }, $subPlan);
    }

    public function getAllPreviousSubtasks($savedTaskId)
    {
        $previousSubTasks = SubPlan::where('saved_task_id', $savedTaskId)
        ->where('created_at', '<', $this->getUserTime('Y-m-d') . ' 00:00:00')
        ->get()
        ->toArray();  

        return $previousSubTasks;
    }

    public function updateOldSubtasks() {
        $currentUserSavTasksId = $this->getCurrentUserSavTasksId();
        if (count($currentUserSavTasksId)) {
            $this->addIsFailedStatus($currentUserSavTasksId);
            $this->removeCheckpointStatus($currentUserSavTasksId);
            $this->removeIsFailedFromReady($currentUserSavTasksId);
        }
    }

    private function getCurrentUserSavTasksId() {
        $currentUserSavTasksId = SavedTask::select('id')
        ->where('user_id', Auth::id())
        ->get()
        ->toArray();

        return $currentUserSavTasksId;
    }

    private function addIsFailedStatus($currentUserSavTasksId)
    {
        $currentSubtasksId = SubPlan::select(['id'])
        ->where('is_ready', 0)
        ->where('created_at', '<', $this->getUserTime('Y-m-d') . ' 00:00:00')
        ->where('is_failed', 0)
        ->whereIn('saved_task_id', $currentUserSavTasksId)
        ->get()
        ->toArray();

        if (count($currentSubtasksId)) {
            SubPlan::whereIn('id', $currentSubtasksId)->update(['is_failed' => 1]);
        }
    }

    private function removeCheckpointStatus($currentUserSavTasksId) 
    {
        $currentSubtasksId = SubPlan::select(['id'])
        ->where('is_ready', 0)
        ->where('checkpoint', 1)
        ->where('created_at', '<', $this->getUserTime('Y-m-d') . ' 00:00:00')
        ->whereIn('saved_task_id', $currentUserSavTasksId)
        ->get()
        ->toArray();

        if (count($currentSubtasksId)) {
            SubPlan::whereIn('id', $currentSubtasksId)->update(['checkpoint' => 0]);
        }
    }

    public function removeIsFailedFromReady($currentUserSavTasksId) 
    {
        $readyFailedSubtasksId =  SubPlan::select(['id'])
        ->where('is_ready', 1)
        ->where('is_failed', 1)
        ->whereNotNull('done_at_user_time')
        ->where('done_at_user_time', '<', $this->getUserTime('Y-m-d') . ' 00:00:00')
        ->whereIn('saved_task_id', $currentUserSavTasksId)
        ->get()
        ->toArray();
        
        if (count($readyFailedSubtasksId)) {
            SubPlan::whereIn('id', $readyFailedSubtasksId)->update(['is_failed' => 0]);
        }
    }

    public function getUserTime($format) 
    {
        $currentUserTimeZone = User::select(['timezone'])
        ->where('id', Auth::id())
        ->get()
        ->toArray();

        if (count($currentUserTimeZone)) {
            $currentUserTimeZone = $currentUserTimeZone[0]['timezone'];
            date_default_timezone_set($currentUserTimeZone);
            
            return date($format);
        }
    }
}