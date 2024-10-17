<?php

namespace App\Repositories;


use Carbon;
use App\Models\TimetableModel;
use App\Models\PersonalConfigs;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use App\Models\Preplan;

class WeekendRepository
{
    private $timetableModel       = null;
    private $generalHelper        = null;
    private $preplanModel         = null;
    private $preplansDateRange    = null;
    private $settings             = [];

    public function __construct(TimetableModel $timetableModel,
                                GeneralHelper  $generalHelper,
                                Preplan        $preplan,
                                )
    {
        $this->timetableModel = $timetableModel;
        $this->generalHelper  = $generalHelper;
        $this->preplanModel   = $preplan;
    }

    private function getSettingsByKey($key)
    {
        return $this->settings[$key];
    }

    private function setSettings($prePlanDate)
    {
        $userId               = Auth::id();
        $timeZone             = $this->generalHelper::getUserTimeZone();
        $preplanDate          = $prePlanDate;
        $prePlanCarbonDate    = Carbon\CarbonImmutable::createFromFormat('Y-m-d', $prePlanDate, $timeZone);
        $prePlanWeekStartDate = $prePlanCarbonDate->startOfWeek()->format('Y-m-d');
        $prePlanWeekEndDate   = $prePlanCarbonDate->endOfWeek()->format('Y-m-d');
        $todayCarbonDate      = $this->generalHelper::getUserTodayDate();
        $todayDate            = $todayCarbonDate->toDateString();
        $currentWeekEndDate   = $todayCarbonDate->copy()->endOfWeek()->format('Y-m-d');
        $isPreplanFutureWeek  = $this->generalHelper::checkIfDateIsLater($prePlanDate, $currentWeekEndDate);

        $this->settings = [
            'userId'               => $userId,
            'preplanDate'          => $preplanDate,
            'prePlanCarbonDate'    => $prePlanCarbonDate,
            'prePlanWeekStartDate' => $prePlanWeekStartDate,
            'prePlanWeekEndDate'   => $prePlanWeekEndDate,
            'todayCarbonDate'      => $todayCarbonDate,  
            'todayDate'            => $todayDate,
            'currentWeekEndDate'   => $currentWeekEndDate,
            'isPreplanFutureWeek'  => $isPreplanFutureWeek,
        ];
    }

    

    public function isWeekendAvailable($prePlanDate)
    {
        $this->setSettings($prePlanDate);
        $this->setPreplansDateRange();
        
        $timetablesDateRange   = [$this->getSettingsByKey('prePlanWeekStartDate'), $this->getSettingsByKey('prePlanWeekEndDate')];
        
        $timetablesQuery = $this->timetableModel::selectRaw('count(*) as count')
                                ->where('user_id', $this->getSettingsByKey('userId'))
                                ->where('day_status', 1)
                                ->whereBetween('date', $timetablesDateRange)
                                ->where('date', '!=', $this->getSettingsByKey('preplanDate')); 
    
        $preplansQuery  = $this->getPreplansQuery();
                                
        return  $timetablesQuery->unionAll($preplansQuery)->get()->sum('count');
    }

   

    public function weekendNumber()
    {
        return (json_decode(PersonalConfigs::select('config_data')
            ->where('config_block_id', 2)
            ->where('user_id', Auth::id())
            ->get()->toArray()[0]['config_data'])
            ->rules[0]->weekends);
    }

    private function getPreplansDateRange()
    {
        return $this->preplansDateRange;
    }

    private function setPreplansDateRange() 
    {
        if ($this->getSettingsByKey('isPreplanFutureWeek')) {
            $this->preplansDateRange = [$this->getSettingsByKey('prePlanWeekStartDate'), $this->getSettingsByKey('prePlanWeekEndDate')];
        } else {
            $this->preplansDateRange = [$this->getSettingsByKey('todayDate'), $this->getSettingsByKey('currentWeekEndDate')];
        }

    }

    private function getPreplansQuery()
    {
        $baseQuery = $this->preplanModel::selectRaw('count(*) as count')
                            ->where('user_id', $this->getSettingsByKey('userId'))
                            ->where('day_status', 1)
                            ->whereBetween('date', $this->getPreplansDateRange());

        if ($this->getSettingsByKey('isPreplanFutureWeek')) {
            return $baseQuery->where('date', '!=', $this->getSettingsByKey('preplanDate'));
        }

        $isPlanCreatedForToday = $this->getSettingsByKey('prePlanCarbonDate')->isSameDay($this->getSettingsByKey('todayCarbonDate'));
        if ($isPlanCreatedForToday) {
            return $baseQuery->where('date', '!=', $this->getSettingsByKey('todayDate'));
        }

        $isTodayPlanExists = $this->checkIsTodayPlanExists();
        
        if ($isTodayPlanExists) {
           $baseQuery->where('date', '!=', $this->getSettingsByKey('todayDate'));
        } else {
           $baseQuery->where('date', '!=', $this->getSettingsByKey('preplanDate'));
        }
        return $baseQuery;
    }

    private function checkIsTodayPlanExists()
    {
        return $this->timetableModel::where('date', $this->getSettingsByKey('todayDate'))
                                    ->where('user_id', $this->getSettingsByKey('userId'))
                                    ->exists();
    }
}
