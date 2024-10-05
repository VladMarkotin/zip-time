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
use App\Http\Helpers\GeneralHelpers\GeneralHelper;

class HistService
{
    private $carbon                    = null;
    private $histRepository            = null;
    private $histTransformationService = null;
    private $timeTable                 = null;
    private $generealHelper            = null;

    public function __construct(Carbon $carbon, 
                                HistRepository $histRepository,
                                HistTransformationService $histTransformationService,
                                TimetableModel $timeTable,
                                GeneralHelper $generalHelper,
                                )
    {
        $this->carbon                    = $carbon;
        $this->histRepository            = $histRepository;
        $this->histTransformationService = $histTransformationService;
        $this->timeTable                 = $timeTable;
        $this->generealHelper            = $generalHelper;
    }

    public function getHist($startDate)
    {   
        $period["today"]          = $this->generealHelper::getUsetTodayDate()->toDateString();
        $period["from"]           = $startDate;
        $period["to"]             = Carbon::createFromFormat('Y-m-d', $period["from"])->endOfMonth()->toDateString();
        $period["with_failed"]    = 0;
        $period["with_weekend"]   = 1;
        $period["with_emergency"] = 0;

        $response = $this->histRepository->getHist($period);
        $response = $this->histTransformationService->transformHistResponse($response, $period["today"]);
        
        return ( json_encode($response, JSON_UNESCAPED_UNICODE));
     }

    public function getHistforClosedDay($date, $user_id, $flag)
    {
        $responseData = [];
        $currentDayData = $this->getCurrentDayData($date, $user_id, $flag);

        $doesTheDayExistBefore = $this->timeTable::where('date', '<', $currentDayData['date'])->where('user_id', $user_id)->exists();
        $doesTheDayExistAfter  = $this->timeTable::where('date', '>', $currentDayData['date'])->where('user_id', $user_id)->exists();

        $isDayMissed = !count($currentDayData);
        $responseData['isDayMissed']           = $isDayMissed;
        $responseData['doesTheDayExistBefore'] = $doesTheDayExistBefore;
        $responseData['doesTheDayExistAfter']  = $doesTheDayExistAfter;

        if (!$isDayMissed) {
            $transformedKeys = array_map(function($key) {
                switch ($key) {
                    case 'date':
                        return 'date';
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
            }, array_keys($currentDayData));
            $currentDayData = array_combine($transformedKeys, $currentDayData);

            $responseData['currentDayData'] = $currentDayData;
        }

        return $responseData;
    }

    private function getCurrentDayData($date, $user_id, $flag) 
    {
        switch($flag) {
            case 'prev':
                return $this->timeTable
                ->select('date', 'day_status', 'final_estimation', 'own_estimation', 'comment')
                ->where('user_id', $user_id)
                ->where('date', '<', $date)
                ->orderBy('date', 'desc')
                ->first()
                ->toArray();
            case 'today':
                return $this->timeTable
                ->select('date', 'day_status', 'final_estimation', 'own_estimation', 'comment')
                ->where('user_id', $user_id)
                ->where('date', $date)
                ->first()
                ->toArray();
            case 'next':
                 return $this->timeTable
                ->select('date', 'day_status', 'final_estimation', 'own_estimation', 'comment')
                ->where('user_id', $user_id)
                ->where('date', '>', $date)
                ->orderBy('date', 'asc')
                ->first() 
                ->toArray();
        }
    }
}
