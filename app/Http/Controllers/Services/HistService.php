<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 29.10.2021
 * Time: 12:47
 */
namespace App\Http\Controllers\Services;


use Carbon\Carbon;
use App\Repositories\HistRepositories\HistRepository;

class HistService
{
    private $carbon         = null;
    private $histRepository = null;

    public function __construct(Carbon $carbon, HistRepository $histRepository)
    {
        $this->carbon         = $carbon;
        $this->histRepository = $histRepository;
    }

    public function getHist(array $period = null)
    {
        if(!$period){
            //$period["type"]           = 0; //?
            $period["from"]           = $this->carbon->startOfWeek()->toDateString();
            $period["to"]             = $this->carbon->endOfWeek()->toDateString();
            $period["with_failed"]    = 0;
            $period["with_weekend"]   = 1;
            $period["with_emergency"] = 0;
        }

        $response = $this->histRepository->getHist($period);

        return ( json_encode($response, JSON_UNESCAPED_UNICODE));
    }
}
