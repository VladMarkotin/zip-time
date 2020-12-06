<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 21.06.2020
 * Time: 7:12
 */
namespace Controllers\Services\PlanServices;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DayInfoService
{
    private $dayInfoRepository;

    public function __construct(\App\Repositories\DayInfoRepository $dayInfoRepository)
    {
        $this->dayInfoRepository = $dayInfoRepository;
    }

    public function createDay($dayStatus)
    {
        $dayInfo = [
            "user_id"          => Auth::id(),
            "date"             => Carbon::today(),
            "day_status"       => $dayStatus,
            "final_estimation" => "",
            "own_estimation"   => "",
            "comment"          => "",
            "necessary"        => "",
            "for_tomorrow"     => ""
        ];

        /*Вставляю данные в бд через $dayInfoRepository*/
        $this->dayInfoRepository->create($dayInfo);

        return $dayInfo;
    }

    public function closeDay($data)
    {
        //die(print_r($data));
        if($data["status"] == "Вых"){
            $dayInfo = [
                "user_id" => Auth::id(),
                "date" => Carbon::today(),
                "day_status" => $data["status"],
                "final_estimation" => -2.00,
                "own_estimation" => $data["own_mark"],
                "comment" => $data["comment"],
                "necessary" => $data["necessary"],
                "for_tomorrow" => $data["for_tomorrow"]
            ];
        }else {
            $dayInfo = [
                "user_id" => Auth::id(),
                "date" => Carbon::today(),
                "day_status" => $data["status"],
                "final_estimation" => "",
                "own_estimation" => $data["own_mark"],
                "comment" => $data["comment"],
                "necessary" => $data["necessary"],
                "for_tomorrow" => $data["for_tomorrow"],
                "weight"       => $data["weight"],
            ];
        }
        //die(print_r($data));
        /*Вставляю данные в бд через $dayInfoRepository*/
        $response = $this->dayInfoRepository->estimateDay($dayInfo);//true - good, false-bad

        return $response;

    }
} 