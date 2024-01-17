<?php

namespace App\Repositories;


use Carbon;
use App\Models\DefaultConfigs;
use App\Models\TimetableModel;
use App\Models\PersonalConfigs;
use Illuminate\Support\Facades\Auth;


class WeekendRepository
{
    private $timetableModel = null;

    public function __construct(TimetableModel $timetableModel)
    {
        $this->timetableModel = $timetableModel;
    }

    public function isWeekendAvailable()
    {

        $id = Auth::id();
        $now = Carbon\CarbonImmutable::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d');
        //die(var_dump($weekStartDate));
        $weekends = TimetableModel::all()
            ->where('user_id', $id)
            ->where('day_status', 1)
            ->whereBetween('date', [$weekStartDate, $weekEndDate])
            //->get()
            ->toArray();
        return $weekends;
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
