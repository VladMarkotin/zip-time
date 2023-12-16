<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPlan;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Services\SubPlanServices\SubPlanService;
use Carbon\Carbon;

class SubPlanController extends Controller
{
    private $subPlan = null;
    private $subPlanService = null;

    public function __construct(SubPlan $subPlan, SubPlanService $subPlanService)
    {
        $this->subPlan        = $subPlan;
        $this->subPlanService = $subPlanService;
    }

    public function createSubPlan(Request $request)
    {
        //TODO Validation
        $subPlan = $request->all()['sub_plan'];

        /*$errors = Validator::make($subPlan, [
            '*.title' => 'required|string|min:2|max:32',
            //'*.text' => 'required',
            //'*.checkpoint'    => 'required|max:191',
        ]);*/

        /*$errors = $request->validate([
            '*.title' => 'required|string|min:3',
        ]);*/
        $errors = [];
        $checkSubPlan = function ($index, $el){
            switch ($index) {
                case 'title': return (strlen($el) > 256 || strlen($el) < 3) ? false : true;
                case 'text': return (strlen($el) > 1000) ? false : true;
                default: true;
            }
        };
        foreach ($subPlan as $k => $v) {
            $errors[] = $checkSubPlan($k, $v);
        }
        if (in_array(false, $errors, true)) {
            return ( response()->json([
                'message' => 'data for subtask is invalid',
                'elements' => $subPlan, 
            ]) );
        }
        /**Have to get saved_task_id */
        $savedTaskId = $this->subPlanService->getSavedTaskId($subPlan);
        if ($savedTaskId) {
            $subPlan['saved_task_id'] = $savedTaskId;
        }
        /**end */
        //die(var_dump($savedTaskId));

        $userTime = $this->subPlanService->getUserTime('Y-m-d H:i:s');
        if (!empty($userTime)) {
            $subPlan['created_at_user_time'] = $userTime;
        }
        
        $taskId = SubPlan::create($subPlan)->id;

        return ( response()->json([
            'message' => 'subtask has been added',
            'elements' => $subPlan, 
            'taskId' => $taskId,
            'completedPercent' => $this->subPlanService->countPercentOfCompletedWork(['task_id' => $subPlan['task_id']]),
        ]) );
    }

    public function getSubPlan(Request $request)
    {
        $this->updateOldSubtasks(); //перенести

        $currentUserTime = $this->subPlanService->getUserTime('Y-m-d');
        $savedTaskId = $this->subPlanService->getSavedTaskId(['task_id' => $request->get('task_id')]);
        $id = $request->get('task_id');

        $getSubplan = function($columnName, $columnVal, $currentUserTime) {
            $subPlan = SubPlan::where([[$columnName, $columnVal]])
            ->where('created_at', '>', $currentUserTime.' 00:00:00')
            ->get()
            ->toArray();

            return $subPlan;
        };
        
        if ($savedTaskId) {
            $subPlan = $getSubplan('saved_task_id', $savedTaskId, $currentUserTime);

            $lastId = count($subPlan) ? [$subPlan[count($subPlan) - 1]] : [];

            $failedSubtasks = $this->subPlanService->getFailedSubtasks($savedTaskId);
            
            if (count($failedSubtasks)) {
                foreach ($failedSubtasks as $v) {
                    $subPlan[] = $v;
                }
            }
        } else {
            $subPlan = $getSubplan('task_id', $request->get('task_id'), $currentUserTime);

            $lastId = SubPlan::select('id')
            ->where('task_id', $id)
            ->get()
            ->toArray();
        }

        $lastTaskId = count($lastId) ? $this->getLastTaskId($lastId[0]['id']) : null;

        return (
            response()->json([
                'status' => 'success', 
                'data' => $subPlan, 
                'completedPercent' => $this->subPlanService->countPercentOfCompletedWork(['task_id' => $lastTaskId ? $lastTaskId : $request->get('task_id')]),
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    public function delSubTask(Request $request)
    {
        $id = $request->get('task_id');
        $lastTaskId = $this->getLastTaskId($id);
        $res = SubPlan::where('id',$id)->delete();
        
        return (
            response()->json([
                'status' => 'success', 
                'completedPercent' => $this->subPlanService->countPercentOfCompletedWork(['task_id' => $lastTaskId]), 
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    public function completeSubTask(Request $request)
    {
        $id       = $request->get('task_id');
        $is_ready = $request->get('is_task_ready');
        SubPlan::whereId($id)->update(['is_ready' => $is_ready]);
        $lastTaskId = $this->getLastTaskId($id);
        $completedPercent = $this->subPlanService->countPercentOfCompletedWork(['task_id' => $lastTaskId]);

        $this->editDoneAtColumn($id, $is_ready);

        return (
            response()->json([
                'status' => 'success', 
                'message' => 'subtask has been completed',
                'completedPercent' =>  $completedPercent,
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    

    private function editDoneAtColumn($id, $is_ready) 
    {
        $date = !empty($is_ready) ? $this->subPlanService->getUserTime('Y-m-d H:i:s') : null;
        SubPlan::whereId($id)->update(['done_at_user_time' => $date]);
    }

    public function editSubTask(Request $request)
    {
        /**Add validation */
        SubPlan::where('id', $request->all()['id'])->update($request->all());
        /**end */
        return (
            response()->json([
                'status' => 'success', 
                'message' => 'Subtask has been updated',
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    private function updateOldSubtasks() {
        $currentUserSavTasksId = $this->subPlanService->getCurrentUserSavTasksId();

        if (count($currentUserSavTasksId)) {
            $this->subPlanService->addIsFailedStatus($currentUserSavTasksId);
            $this->subPlanService->removeCheckpointStatus($currentUserSavTasksId);
            $this->subPlanService->removeIsFailedFromReady($currentUserSavTasksId);
        }
    }

    private function getLastTaskId($id)
    {   
        $savedTaskId = SubPlan::find($id);
        
        if ($savedTaskId) {
            $savedTaskId = $savedTaskId->saved_task_id;
            return $subPlan = SubPlan::select('task_id')->where('saved_task_id', $savedTaskId)->orderBy('created_at', 'desc')->get()->toArray()[0]['task_id'];
        } 
        $subPlan = SubPlan::select('task_id')->where('id',$id)->get()->toArray();
        return count($subPlan) ? $subPlan[0]['task_id'] : $subPlan;
    }
}
