<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 13.09.2020
 * Time: 6:29
 */

namespace App\Http\Controllers;


use Controllers\Services\PlanServices\DisplayPlanService as PlanService;
use Controllers\Services\PlanServices\DayInfoService;

class HistController
{
    private $planService;
    private $dayInfoService;
    private $dayPlanHistory;

    public function __construct(PlanService $planService,
                                DayInfoService $dayInfoService)
    {
        $this->planService    = $planService;
        $this->dayInfoService = $dayInfoService;
    }

    public function index()
    {
        $id = \Illuminate\Support\Facades\Auth::id();
        $result = $this->planService->getAllPlansOfUser($id);
        if($result){
            $this->dayPlanHistory = $result;
     //       dd($result);
            return view("history.index")->with(["history" => $result]);
        } else{
            return view("history.index")->with(["history" => []]);
        }
    }

    public function showDayPlanHist($dateOfTimetable)
    {
        $id = \Illuminate\Support\Facades\Auth::id();
        $result = $this->planService->getConcretePlan($id,$dateOfTimetable);
        if($result) {
            return view("history.hist")->with(["histDayPlan" => $result]);
        }

        return ;
    }
} 