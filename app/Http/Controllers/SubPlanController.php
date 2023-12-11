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
        $currentUserSavTaskId = $this->subPlanService->addIsFailedStatus();
        $this->subPlanService->removeCheckpointStatus($currentUserSavTaskId);

        $savedTaskId = $this->subPlanService->getSavedTaskId(['task_id' => $request->get('task_id')]);
        $subPlan = SubPlan::where('task_id', $request->get('task_id'))->get()->toArray();
        //die(var_dump($request->get('task_id'))); 
        //die(var_dump($savedTaskId));    
        if ($savedTaskId) {

            $previousSubTasks = SubPlan::where('saved_task_id', $savedTaskId)
            ->where('is_ready', 0)
            ->where('created_at', '<', date('Y-m-d').' 00:00:00') //раскомментировал эту строчку
            ->get()
            ->toArray();  
            if (count($previousSubTasks)) {
                foreach ($previousSubTasks as $v) {
                    $subPlan[] = $v;
                }
            }
        }
       //die(var_dump(count($subPlan)));
        return (
            response()->json([
                'status' => 'success', 
                'data' => $subPlan, 
                'completedPercent' => $this->subPlanService->countPercentOfCompletedWork(['task_id' => $request->get('task_id')]), 
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    public function delSubTask(Request $request)
    {
        $id = $request->get('task_id');
        $subPlan = SubPlan::select('task_id')->where('id',$id)->get()->toArray();
        $res = SubPlan::where('id',$id)->delete();
        //die(var_dump($subPlan[0]['task_id']));
        return (
            response()->json([
                'status' => 'success', 
                'completedPercent' => $this->subPlanService->countPercentOfCompletedWork(['task_id' => $subPlan[0]['task_id']]), 
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    public function completeSubTask(Request $request)
    {
        $id       = $request->get('task_id');
        $is_ready = $request->get('is_task_ready');
        SubPlan::whereId($id)->update(['is_ready' => $is_ready]);
        $parentTaskId = $this->getParentTaskId($id);
        return (
            response()->json([
                'status' => 'success', 
                'message' => 'subtask has been completed',
                'completedPercent' =>  $this->subPlanService->countPercentOfCompletedWork(['task_id' => $parentTaskId]),
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
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

    private function getParentTaskId($id)
    {
        $subPlan = SubPlan::select('task_id')->where('id',$id)->get()->toArray();

        return $subPlan[0]['task_id'];
    }
}
