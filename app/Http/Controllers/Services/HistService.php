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
use App\Models\TimetableModel;

class HistService
{
    private $carbon                    = null;
    private $histRepository            = null;
    private $histTransformationService = null;
    private $timeTable                 = null;

    public function __construct(Carbon $carbon, 
                                HistRepository $histRepository,
                                HistTransformationService $histTransformationService,
                                TimetableModel $timeTable
                                )
    {
        $this->carbon                    = $carbon;
        $this->histRepository            = $histRepository;
        $this->histTransformationService = $histTransformationService;
        $this->timeTable                 = $timeTable;
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

    public function getHistforClosedDay($date, $user_id)
    {
        $responseData = [];

        $currentDayData = $this->timeTable
        ->select('date', 'day_status', 'final_estimation', 'own_estimation', 'comment')
        ->where('user_id', $user_id)
        ->where('date', $date)
        ->get()
        ->toArray();

        $doesTheDayExistBefore = $this->timeTable::where('date', '<', $date)->where('user_id', $user_id)->exists();
        $doesTheDayExistAfter  = $this->timeTable::where('date', '>', $date)->where('user_id', $user_id)->exists();

        $isDayMissed = !count($currentDayData);
        $responseData['isDayMissed']      = $isDayMissed;
        $responseData['doesTheDayExistBefore'] = $doesTheDayExistBefore;
        $responseData['doesTheDayExistAfter']  = $doesTheDayExistAfter;

        
        if (!$isDayMissed) {
            $transformedKeys = array_map(function($key) {
                switch ($key) {
                    case 'day_status':
                        return 'dayStatus';
                    case 'final_estimation':
                        return 'dayFinalMark';
                    case 'own_estimation':
                        return 'dayOwnMark';
                    case 'comment':
                        return 'commentText';
                    default:
                        return $key;
                }
            }, array_keys($currentDayData[0]));
            $currentDayData = array_combine($transformedKeys, $currentDayData[0]);

            $responseData['currentDayData'] = $currentDayData;
        }

        return $responseData;
    }
}
