<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPlan;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Services\SubPlanServices\SubPlanService;

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
        $subPlan = SubPlan::where('task_id', $request->get('task_id'))->get()->toArray();
       
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
        $id = $request->get('task_id');
        SubPlan::whereId($id)->update(['is_ready' => true]);
        $parentTaskId = $this->getParentTaskId($id);
        return (
            response()->json([
                'status' => 'success', 
                'message' => 'Subtask has been completed',
                'completedPercent' =>  $this->subPlanService->countPercentOfCompletedWork(['task_id' => $parentTaskId]),
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