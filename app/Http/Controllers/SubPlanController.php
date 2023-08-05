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
        //TODO
        /*$request->validate([
            'title' => 'required|string|max:255|min:3',
            'weight' => 'required|integer|max:100|min:1',
            'position' => 'required|date',
        ]);*/
        $subPlan = $request->all()['sub_plan'];
        

        SubPlan::insert($subPlan);
        die(var_dump($subPlan));// ok
    }
}
