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
    private $userId               = null;
    private $preplanDate          = null;
    private $prePlanCarbonDate    = null;
    private $prePlanWeekStartDate = null;
    private $prePlanWeekEndDate   = null;
    private $preplansDateRange    = null;
    private $todayDate            = null;
    private $todayCarbonDate      = null;
    private $currentWeekEndDate   = null;
    private $isPreplanFutureWeek  = null;
    private $istodayPlanExists    = null;

    public function __construct(TimetableModel $timetableModel,
                                GeneralHelper  $generalHelper,
                                Preplan        $preplan,
                                )
    {
        $this->timetableModel = $timetableModel;
        $this->generalHelper  = $generalHelper;
        $this->preplanModel   = $preplan;
    }

    public function init($prePlanDate)
    {
        $this->userId               = Auth::id();
        $timeZone                   = $this->generalHelper::getUserTimeZone();
        $this->preplanDate          = $prePlanDate;
        $this->prePlanCarbonDate    = Carbon\CarbonImmutable::createFromFormat('Y-m-d', $prePlanDate, $timeZone);
        $this->prePlanWeekStartDate = $this->prePlanCarbonDate->startOfWeek()->format('Y-m-d');
        $this->prePlanWeekEndDate   = $this->prePlanCarbonDate->endOfWeek()->format('Y-m-d');
        $this->todayCarbonDate      = $this->generalHelper::getUserTodayDate();
        $this->todayDate            = $this->todayCarbonDate->toDateString();
        $this->currentWeekEndDate   = $this->todayCarbonDate->copy()->endOfWeek()->format('Y-m-d');
        $this->isPreplanFutureWeek  = $this->generalHelper::checkIfDateIsLater($prePlanDate, $this->currentWeekEndDate);
    }

    

    public function isWeekendAvailable($prePlanDate)
    {
        $this->init($prePlanDate);
        $this->setPreplansDateRange();
        $this->setIsTodayPlanExists();
        
        $timetablesDateRange   = [$this->prePlanWeekStartDate, $this->prePlanWeekEndDate];
        
        $timetablesQuery = $this->timetableModel::selectRaw('count(*) as count')
                                ->where('user_id', $this->userId)
                                ->where('day_status', 1)
                                ->whereBetween('date', $timetablesDateRange)
                                ->where('date', '!=', $this->preplanDate); 
    
        $preplansQuery  = $this->getPreplansQuery();
        // dd($timetablesQuery->unionAll($preplansQuery)->get()->toArray());                        
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
        if ($this->isPreplanFutureWeek) {
            $this->preplansDateRange = [$this->prePlanWeekStartDate, $this->prePlanWeekEndDate];
        } else {
            $this->preplansDateRange = [$this->todayDate, $this->currentWeekEndDate];
        }

    }

    private function getPreplansQuery()
    {
        //Если преплан создается на сегодня, то сегодняшний преплан выкидываю
        if ($this->isPreplanFutureWeek) {
            return $this->preplanModel::selectRaw('count(*) as count')
                                    ->where('user_id', $this->userId)
                                    ->where('day_status', 1)
                                    ->whereBetween('date', $this->getPreplansDateRange())
                                    ->where('date', '!=', $this->preplanDate);
        }
        
        return $this->preplanModel::selectRaw('count(*) as count')
                                ->where('user_id', $this->userId)
                                ->where('day_status', 1)
                                ->whereBetween('date', $this->getPreplansDateRange())
                                ->when($this->getIsTodayPlanExists(), function($query) {
                                    return $query->where('date', '!=', $this->todayDate);
                                });
    }

    private function getIsTodayPlanExists()
    {
        return $this->istodayPlanExists;
    }

    private function setIsTodayPlanExists()
    {
        $this->istodayPlanExists = $this->timetableModel::where('date', $this->todayDate)
                                        ->where('user_id', $this->userId)
                                        ->exists();
    }
}
