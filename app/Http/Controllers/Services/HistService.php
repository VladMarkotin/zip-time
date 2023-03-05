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
use App\Http\Controllers\Services\HistTransformationService;

class HistService
{
    private $carbon         = null;
    private $histRepository = null;
    private $histTransformationService = null;

    public function __construct(Carbon $carbon, HistRepository $histRepository,
                                HistTransformationService $histTransformationService)
    {
        $this->carbon         = $carbon;
        $this->histRepository = $histRepository;
        $this->histTransformationService = $histTransformationService;
    }

    public function getHist($startDate)
    {
        $period["from"]           = $startDate;
        $period["to"]             = $this->carbon->endOfWeek()->toDateString();
        $period["with_failed"]    = 0;
        $period["with_weekend"]   = 1;
        $period["with_emergency"] = 0;

        $response = $this->histRepository->getHist($period);
        //returns nothing `cause i work with object 
        $this->histTransformationService->transformHistResponse($response);
        
        return ( json_encode($response, JSON_UNESCAPED_UNICODE));
     }
}
