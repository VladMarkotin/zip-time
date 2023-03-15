<?php
namespace App\Repositories;


use Carbon;
use App\Models\TimetableModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\DayPlanRepositories\AddNoteToSavedTask;

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
}
