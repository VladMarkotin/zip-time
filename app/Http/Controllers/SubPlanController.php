<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPlan;

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
        

        //die(var_dump($subPlan));// ok
        SubPlan::insert($subPlan);
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
        var_dump($request->all() );
        die();
    }
}
