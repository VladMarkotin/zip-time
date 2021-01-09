<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09.12.2020
 * Time: 8:57
 */
namespace Controllers\Services\StatServices;


use App\Repositories\DayInfoRepository;
use App\Repositories\StatRepository;
use App\Repositories\StatRepository2;

class StatService
{
    private $dayInfoRepository = null;
    private $statRepository    = null;

    public function __construct(DayInfoRepository $dayInfoRepository,
                                StatRepository2 $statRepository2
                                )
    {
        $this->dayInfoRepository = $dayInfoRepository;
        $this->statRepository    = $statRepository2;
    }

    public function getTotalTime($data)
    {
        $totalTime = $this->statRepository->getTotalTime($data);

        return $totalTime;
    }

    public function getAvgMark(array $data)
    {
        $avgMark = $this->statRepository->getAvgMark($data);

        return ($avgMark); //попадаю
    }

    public function getAvgOwnMark(array $data)
    {
        $avgOwnMark = $this->statRepository->getAvgOwnMark($data);

        return ($avgOwnMark); //попадаю
    }

    public function getMaxMark(array $data)
    {
        $maxMark = $this->statRepository->getMaxMark($data);

        return ($maxMark); //попадаю
    }

    public function getMinMark(array $data)
    {
        $minMark = $this->statRepository->getMinMark($data);

        return ($minMark); //попадаю
    }

    public function getMedianValue(array $data, $param = 0)
    {
        $median = $this->statRepository->getMedian($data, $param);

        return $median;
    }

    public function getPieceOfTime($data)
    {
        switch($data["period"]){
            case "quart":
                return $this->getQuarter();
            case "month":
                return $this->getMonth();
            case "week":
                return $this->getWeek();
        }

    }

    private function getQuarter()
    {
        $date = new \Carbon\Carbon('-3 months');
        $firstOfQuarter = $date->firstOfQuarter()->toDateString();
        $lastOfQuarter = $date->lastOfQuarter()->toDateString();
        $response = ["start" => $firstOfQuarter, "end" => $lastOfQuarter];
        //dd($response);

        return $response;
    }

    private function getMonth()
    {
        $date = new \Carbon\Carbon('-1 month');
        $firstOfMonth = $date->firstOfMonth()->toDateString();
        $lastOfMonth = $date->lastOfMonth()->toDateString();
        $response = ["start" => $firstOfMonth, "end" => $lastOfMonth];

        return $response;
    }

    private function getWeek()
    {
        $date = new \Carbon\Carbon('-1 week');
        $firstOfWeek = $date->startOfWeek()->format('Y-m-d');;
        $endOfWeek   = $date->endOfWeek()->format('Y-m-d');
        $response    = ["start" => $firstOfWeek, "end" => $endOfWeek];

        return $response;
    }
} 