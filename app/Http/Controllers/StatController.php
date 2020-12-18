<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 08.12.2020
 * Time: 11:35
 */
namespace App\Http\Controllers;


use Controllers\Services\PlanServices\DisplayPlanService as PlanService;
use Controllers\Services\PlanServices\DayInfoService;
use Controllers\Services\StatServices\StatService as StatService;
use Illuminate\Support\Carbon;

class StatController extends Controller {

    private $planService;
    private $dayInfoService;
    private $dayStatService;
    private $carbon;

    public function __construct(PlanService $planService,
                                DayInfoService $dayInfoService,
                                StatService $statService,
                                Carbon $carbon)
    {
        $this->planService    = $planService;
        $this->dayInfoService = $dayInfoService;
        $this->dayStatService = $statService;
        $this->carbon         = $carbon;
    }

    public function index()
    {
        $id = \Illuminate\Support\Facades\Auth::id();
        $result = $this->planService->getAllPlansOfUser($id);
        if($result){
            $this->dayPlanStat = $result; //может быть не надо

                 //dd($result);
            return view('stat.index')->with(["history" => $result]);
        } else{
            return view("stat.index")->with(["history" => []]);
        }
    }

    public function period($param = null)
    {
        $id = \Illuminate\Support\Facades\Auth::id();
        $period = (!isset($param)) ? "Статистика за все время": "Статистика за..";
        $data = ["id" => $id, "date" => $this->carbon->today()->toDateString(), "period" => $period];
        $totalTime = $this->dayStatService->getTotalTime($data);
        $avgMark = $this->dayStatService->getAvgMark($data);
        $avgOwnMark = $this->dayStatService->getAvgOwnMark($data);
        $maxMark = $this->dayStatService->getMaxMark($data);
        $minMark = $this->dayStatService->getMinMark($data);
        $medianValue = $this->dayStatService->getMedianValue($data);
        $medianOwnValue = $this->dayStatService->getMedianValue($data, 1);

        return view('stat.index')->with(["period" => $period,"avgMark" => $avgMark, "avgOwnMark" => $avgOwnMark, "maxMark" => $maxMark,
            "minMark" => $minMark, "totalTime" =>$totalTime, "medianValue" => $medianValue, "medianOwnValue" => $medianOwnValue]);
    }
} 