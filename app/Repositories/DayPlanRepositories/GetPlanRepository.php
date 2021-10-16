<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 22.08.2021
 * Time: 14:08
 */

namespace App\Repositories\DayPlanRepositories;


use App\Models\DayPlanModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetPlanRepository
{
    private $dayPlanModel = null;

    public function __construct(DayPlanModel $dayPlanModel)
    {
        $this->dayPlanModel = $dayPlanModel;
    }

    public function getLastDayPlan(array $data)
    {
        //сперва получу timetable_id
        $timetableId = $this->getLastTimetableId($data);
        //потом сам план
        $plan = $this->getTasksForLastTimetable($timetableId);

        return $plan;
    }

    public function getDateOfLastTimetable(array $data)
    {
        $dayPlan = DB::table('timetables')->where('date', '=', $data['date'])
            ->where('user_id', '=', $data['id'])
            ->get('date')
            ->toArray();
        if(!$dayPlan){
            return false;
        }

        return true;
    }

    public function getLastTimetableId($data)
    {
        $dayPlan = DB::table('timetables')->where('date', '=', $data['date'])
            ->where('user_id', '=', $data['id'])
            ->get()
            ->toArray();

        return $dayPlan[0]->id;
    }

    private function getTasksForLastTimetable($timetableId)
    {
        $tasks = DB::table('tasks')->join('timetables','tasks.timetable_id', '=', 'timetables.id')
                ->select('tasks.*') //потом заменить звездочку на конкретные поля
                ->where('timetables.user_id', '=', Auth::id())
                ->where('timetables.id', '=', $timetableId)
                ->get()
                ->toArray();

        return $tasks;
    }
} 