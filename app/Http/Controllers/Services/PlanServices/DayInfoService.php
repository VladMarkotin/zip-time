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
} 