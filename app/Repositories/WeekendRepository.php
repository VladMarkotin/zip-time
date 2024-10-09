<?php

namespace App\Repositories;


use Carbon;
use App\Models\DefaultConfigs;
use App\Models\TimetableModel;
use App\Models\PersonalConfigs;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use App\Models\Preplan;


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

        $id = Auth::id();
        $time_zone = $this->generalHelper::getUserTimeZone();
        $cardon_date = Carbon\CarbonImmutable::createFromFormat('Y-m-d', $date, $time_zone);
        $weekStartDate = $cardon_date->startOfWeek()->format('Y-m-d');
        $weekEndDate = $cardon_date->endOfWeek()->format('Y-m-d');
        
        $weekend_in_timetables = TimetableModel::selectRaw('count(*) as count')
            ->where('user_id', $id)
            ->where('day_status', 1)
            ->whereBetween('date', [$weekStartDate, $weekEndDate])
            ->where('date', '!=', $cardon_date->toDateString())
            ->get()
            ->sum('count');
    
        $weekend_in_preplans = $this->preplanModel::selectRaw('count(*) as count')
            ->where('user_id', $id)
            ->where('day_status', 1)
            ->whereBetween('date', [$weekStartDate, $weekEndDate])
            ->where('date', '!=', $cardon_date->toDateString())
            ->get()
            ->sum('count');

        return  $weekend_in_timetables + $weekend_in_preplans;
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
