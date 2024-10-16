<?php

namespace App\Repositories;


use Carbon;
use App\Models\DefaultConfigs;
use App\Models\TimetableModel;
use App\Models\PersonalConfigs;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use App\Models\Preplan;
use Illuminate\Support\Facades\DB;


class WeekendRepository
{
    private $timetableModel = null;
    private $generalHelper  = null;
    private $preplanModel   = null;

    public function __construct(TimetableModel $timetableModel,
                                GeneralHelper  $generalHelper,
                                Preplan        $preplan,
                                )
    {
        $this->timetableModel = $timetableModel;
        $this->generalHelper  = $generalHelper;
        $this->preplanModel   = $preplan;
    }

    public function isWeekendAvailable($prePlanDate)
    {
        $userId                = Auth::id();
        $timeZone              = $this->generalHelper::getUserTimeZone();
        $prePlanCarbonDate     = Carbon\CarbonImmutable::createFromFormat('Y-m-d', $prePlanDate, $timeZone);
        $prePlanWeekStartDate  = $prePlanCarbonDate->startOfWeek()->format('Y-m-d');
        $prePlanWeekEndDate    = $prePlanCarbonDate->endOfWeek()->format('Y-m-d');
        $todayCarbonDate       = $this->generalHelper::getUserTodayDate();
        $tomorrowDate          = $todayCarbonDate->addDay()->toDateString();
        $currentWeekEndDate    = $todayCarbonDate->endOfWeek()->format('Y-m-d');
        $isPreplanFutureWeek   = $this->generalHelper::checkIfDateIsLater($prePlanDate, $currentWeekEndDate);
        
        $timetablesDateRange   = [$prePlanWeekStartDate, $prePlanWeekEndDate];
        $preplansDateRange     = $this->getPreplansDateRange(
                                                                $tomorrowDate, 
                                                                $currentWeekEndDate, 
                                                                $prePlanWeekStartDate, 
                                                                $prePlanWeekEndDate, 
                                                                $isPreplanFutureWeek
                                                            );

        $timetablesQuery = $this->timetableModel::selectRaw('count(*) as count')
                            ->where('user_id', $userId)
                            ->where('day_status', 1)
                            ->whereBetween('date', $timetablesDateRange)
                            ->where('date', '!=', $prePlanCarbonDate->toDateString()); 
    
        $preplansQuery  = $this->preplanModel::selectRaw('count(*) as count')
                            ->where('user_id', $userId)
                            ->where('day_status', 1)
                            ->whereBetween('date', $preplansDateRange)
                            ->where('date', '!=', $prePlanCarbonDate->toDateString());

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

    private function getPreplansDateRange($tomorrowDate, $currentWeekEndDate, $prePlanWeekStartDate, $prePlanWeekEndDate, $isPreplanFutureWeek) 
    {
        /*
        *Если преплан создается на следующую неделю от сегодняшней даты
        *берутся преплан с пн по вск
        */
        if ($isPreplanFutureWeek) {
            return [$prePlanWeekStartDate, $prePlanWeekEndDate];
        }

        /*
        *Если преплан создается на текущую неделю
        *берутся преплан с завтрашнего дня от сегодняшней даты по вск
        */
        return [$tomorrowDate, $currentWeekEndDate];
    }
}
