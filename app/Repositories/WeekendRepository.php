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

    public function isWeekendAvailable($date)
    {

        $id            = Auth::id();
        $timeZone      = $this->generalHelper::getUserTimeZone();
        $carbonDate    = Carbon\CarbonImmutable::createFromFormat('Y-m-d', $date, $timeZone);
        $weekStartDate = $carbonDate->startOfWeek()->format('Y-m-d');
        $weekEndDate   = $carbonDate->endOfWeek()->format('Y-m-d');
        
        $queryOne = $this->timetableModel::selectRaw('count(*) as count')
            ->where('user_id', $id)
            ->where('day_status', 1)
            ->whereBetween('date', [$weekStartDate, $weekEndDate])
            ->where('date', '!=', $carbonDate->toDateString()); 
    
        $queryTwo = $this->preplanModel::selectRaw('count(*) as count')
            ->where('user_id', $id)
            ->where('day_status', 1)
            ->whereBetween('date', [$weekStartDate, $weekEndDate])
            ->where('date', '!=', $carbonDate->toDateString());
            
        return  $queryOne->unionAll($queryTwo)->get()->sum('count');
    }

    public function weekendNumber()
    {
        return (json_decode(PersonalConfigs::select('config_data')
            ->where('config_block_id', 2)
            ->where('user_id', Auth::id())
            ->get()->toArray()[0]['config_data'])
            ->rules[0]->weekends);
    }
}
