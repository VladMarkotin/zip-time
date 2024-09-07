<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPlan;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Services\SubPlanServices\SubPlanService;
use App\Models\Tasks;
use Carbon\Carbon;
use App\Http\Controllers\Services\GetUserTimeService;

class SubPlanController extends Controller
{
    private $subPlan            = null;
    private $subPlanService     = null;
    private $getUserTimeService = null;

    public function __construct(
        SubPlan            $subPlan, 
        SubPlanService     $subPlanService,
        GetUserTimeService $getUserTimeService
    )
    {
        $this->subPlan            = $subPlan;
        $this->subPlanService     = $subPlanService;
        $this->getUserTimeService = $getUserTimeService;
    }

    public function createSubPlan(Request $request)
    {
        //TODO 
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
                'message'  => 'data for subtask is invalid',
                'elements' => $subPlan, 
                'status'   => 'error'
            ]) );
        }
        /**Have to get saved_task_id */
        $savedTaskId = $this->subPlanService->getSavedTaskId($subPlan);
        if ($savedTaskId) {
            $subPlan['saved_task_id'] = $savedTaskId;
        }
        /**end */
        //die(var_dump($savedTaskId));

        $userTime = $this->getUserTimeService->getUserTime('Y-m-d H:i:s');
        if (!empty($userTime)) {
            $subPlan['created_at_user_time'] = $userTime;
        }
        
        $task_id              = $subPlan['task_id'];
        $subtask_id           = SubPlan::create($subPlan)->id;
        $completedPercent     = $this->subPlanService->countPercentOfCompletedWork(['task_id' => $subPlan['task_id']]);
        $resetDayMarkToDefVal = $this->getResetDayMarkToDefVal(
            $subPlan['is_ready'],
            $subPlan['checkpoint'],
            $task_id
        );

        $createResponse = function($subPlan, $subtask_id, $completedPercent, $resetDayMarkToDefVal) 
        {
            return [
                'message'              => 'subtask has been added',
                'elements'             => $subPlan, 
                'subtaskId'            => $subtask_id,
                'completedPercent'     => $completedPercent,
                'resetDayMarkToDefVal' => $resetDayMarkToDefVal,
                'status'               => 'success',
            ];
        };

        $response = $createResponse(
            $subPlan, 
            $subtask_id, 
            $completedPercent, 
            $resetDayMarkToDefVal
        );

        return (response()->json($response));
    }

    public function getSubPlan(Request $request)
    {
        $response = $this->fetchSubPlan($request->get('task_id'), $request->get('mode'));
        
        return (
            response()->json($response, 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    public function fetchSubPlan($task_id, $mode)
    {
        $currentUserTime = $this->getUserTimeService->getUserTime('Y-m-d');

        $savedTaskId = $this->subPlanService->getSavedTaskId(['task_id' => $task_id]);

        $getSubplan = function($columnName, $columnVal, $currentUserTime) {
            $subPlan = SubPlan::where([[$columnName, $columnVal]])
            ->where('created_at_user_time', '>=', $currentUserTime.' 00:00:00')
            ->orderBy('created_at_user_time', 'desc')
            ->get()
            ->toArray();

            return $subPlan;
        };
        
        if ($savedTaskId) {
            $subPlan = $getSubplan('saved_task_id', $savedTaskId, $currentUserTime);
            $lastId = count($subPlan) ? [$subPlan[count($subPlan) - 1]] : [];

            $oldSubtasks = isset($mode)
                ? $this->subPlanService->getAllPreviousSubtasks($savedTaskId)
                : $this->subPlanService->getFailedSubtasks($savedTaskId);
            
            if (count($oldSubtasks)) {
                foreach ($oldSubtasks as $v) {
                    array_unshift($subPlan, $v);
                }
            }

        } else {
            $subPlan = $getSubplan('task_id', $task_id, $currentUserTime);

            $lastId = SubPlan::select('id')
            ->where('task_id', $task_id)
            ->get()
            ->toArray();
        }

        $lastTaskId = count($lastId) ? $this->getLastTaskId($lastId[0]['id']) : null;
        $subPlan = $this->subPlanService->addIsOldCompleatedStatus($subPlan);

        if (count($subPlan) > 1) {

            usort($subPlan, function($subtaskA, $subtaskB) {
                if ($subtaskA['created_at'] === $subtaskB['created_at']) return 0;
                return $subtaskA['created_at'] > $subtaskB['created_at'] ? 1 : -1;
            });
        }

        return (
            [
                'status' => 'success', 
                'data'   => $subPlan, 
                'completedPercent' => $this->subPlanService->countPercentOfCompletedWork(
                    ['task_id' => $lastTaskId ? $lastTaskId : $task_id]
                )
            ]
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
        $subtask_id          = $request->get('subtask_id');
        $is_subtask_ready    = $request->get('is_subtask_ready');
        $task_id             = $request->get('task_id');
        $is_subtask_required = $request->get('is_subtask_required');

        $response = [
            'status'               => 'success', 
            'message'              => 'subtask has been completed',
            'completedPercent'     =>  null,
            'resetDayMarkToDefVal' =>  null,
        ];

        SubPlan::whereId($subtask_id)->update(['is_ready' => $is_subtask_ready]);
        $lastTaskId = $this->getLastTaskId($subtask_id);
        $response['completedPercent'] = $this->subPlanService->countPercentOfCompletedWork(['task_id' => $lastTaskId]);

        $this->editDoneAtColumn($subtask_id, $is_subtask_ready);

        $response['resetDayMarkToDefVal'] = $this->getResetDayMarkToDefVal(
            $is_subtask_ready, 
            $is_subtask_required, 
            $task_id
        );

        return (
            response()->json($response, 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    private function getResetDayMarkToDefVal($is_subtask_ready, $is_subtask_required, $task_id)
    {
        if (!$is_subtask_ready && $is_subtask_required) {
            $task                  = Tasks::find($task_id);
            $mark                  = $task->mark;
            //тут значени задано хардкодом, если значение поля mark отличается от дефолтного, 
            //то сбрасываю до дефолтного
            $defaultMarkFieldValue = -1;

            if ((int) $mark !== $defaultMarkFieldValue) { 
                $task->update(['mark' => $defaultMarkFieldValue]);
                return true;
            }
        }

        return false;
    }

    private function editDoneAtColumn($id, $is_ready) 
    {
        $date = !empty($is_ready) ? $this->getUserTimeService->getUserTime('Y-m-d H:i:s') : null;
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

    private function getLastTaskId($id)
    {   
        $savedTaskId = SubPlan::find($id);
        
        if ($savedTaskId) {
            $savedTaskId = $savedTaskId->saved_task_id;
            return $subPlan = SubPlan::select('task_id')->where('saved_task_id', $savedTaskId)->orderBy('created_at_user_time', 'desc')->get()->toArray()[0]['task_id'];
        } 
        $subPlan = SubPlan::select('task_id')->where('id',$id)->get()->toArray();
        return count($subPlan) ? $subPlan[0]['task_id'] : $subPlan;
    }
}
