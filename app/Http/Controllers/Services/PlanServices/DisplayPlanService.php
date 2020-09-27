<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 15.07.2020
 * Time: 15:21
 */

namespace Controllers\Services\PlanServices;

use Illuminate\Support\Carbon as Carbon;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\DB;

class DisplayPlanService {

    private $dayInfoRepository;
    private $taskRepository;

    public function __construct(\App\Repositories\DayInfoRepository $dayInfoRepository,
                                TaskRepository $taskRepository)
    {
        $this->dayInfoRepository = $dayInfoRepository;
        $this->taskRepository    = $taskRepository;
    }

    public function getAllPlansOfUser($id)
    {
        $query = "select * from tasks where timetable_id IN (select id from timetables where user_id = $id)";
        $result = DB::select($query);
        //dd($result); works

        return $result;
    }

    public function getDayPlan($id)
    {
        $currentDate = Carbon::today()->toDateString();
        $query = "select * from tasks where timetable_id = (select id from timetables where user_id = $id and date = '$currentDate')";
        $result = DB::select($query);

        return $result;
    }

    public function getDayStatus($id)
    {
        $currentDate = Carbon::today()->toDateString();
        $query = "select day_status from timetables where user_id = $id and date = '$currentDate' ";
        $result = DB::select($query);
        if($result == []) return "uiyfg";

        return $result[0]->day_status;
    }

    public function getComment($id)
    {
        $currentDate = Carbon::today()->toDateString();
        $query = "select comment from timetables where user_id = $id and date = '$currentDate' ";
        $result = DB::select($query);
        if($result == []) return "uiyfg";

        return $result[0]->comment;
    }
} 