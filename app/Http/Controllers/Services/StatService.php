<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 26.11.2021
 * Time: 15:35
 */

namespace App\Http\Controllers\Services;

use Illuminate\Support\Carbon;
use RichJenks\Stats\Stats;
use App\Repositories\StatRepositories;

class StatService
{
    private $carbon         = null;
    private $statRepository = null;
    private $statistic      = null;

    public function __construct(Carbon $carbon, StatRepositories\StatRepository $statRepositories, Stats $stats)
    {
        $this->carbon         = $carbon;
        $this->statRepository = $statRepositories;
        $this->statistic      = $stats;

    }

    public function getStat(array $period = null)
    {
        if(!$period){
            //$period["type"]           = 0; //?
            $period["from"]           = $this->carbon->startOfWeek()->toDateString();
            $period["to"]             = $this->carbon->endOfWeek()->toDateString();
        }
        $response = $this->statRepository->getStat($period);

        return ( json_encode($response, JSON_UNESCAPED_UNICODE));
    }
} 