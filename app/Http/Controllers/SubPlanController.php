<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPlan;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class SubPlanController extends Controller
{
    public function __construct(SubPlan $subPlan)
    {
        $this->subPlan = $subPlan;
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
        //die(var_dump($subPlan));// ok
        SubPlan::insert($subPlan);

        return ( response()->json([
            'message' => 'subtask has been added',
            'elements' => $subPlan, 
        ]) );
    }

    public function getSubPlan(Request $request)
    {
        $subPlan = SubPlan::where('task_id', $request->get('task_id'))->get()->toArray();
       
        return (
            response()->json([
                'status' => 'success', 
                'data' => $subPlan, 
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }

    public function delSubTask(Request $request)
    {
        $id = $request->get('task_id');
        $res = SubPlan::where('id',$id)->delete();
        //die();
    }

    public function completeSubTask(Request $request)
    {
        $id = $request->get('task_id');
        SubPlan::whereId($id)->update(['is_ready' => true]);
        
        return (
            response()->json([
                'status' => 'success', 
                'message' => 'Subtask has been completed', 
            ], 200)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_HEX_AMP)
        );
    }
}
