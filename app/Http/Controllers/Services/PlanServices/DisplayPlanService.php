<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 15.07.2020
 * Time: 15:21
 */

namespace Controllers\Services\PlanServices;

use Carbon\CarbonImmutable;
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
        $query = "select  timet.date, timet.time_of_day_plan, timet.day_status,timet.final_estimation,own_estimation,timet.comment,timet.necessary,timet.for_tommorow, tasks.task_name,tasks.status, tasks.mark, tasks.time,
                    tasks.details,tasks.note,tasks.timetable_id from timetables timet RIGHT JOIN tasks ON tasks.timetable_id  = timet.id where
                    tasks.timetable_id IN (select id from timetables where user_id = 1)
                      AND timet.user_id = 1  GROUP BY timet.date  ORDER BY timet.date DESC";//временное решение
        //dd($query);
        $result = DB::select($query);
        //dd($query);
        return $result;
    }

    public function getConcretePlan($id, $date)
    {
        $query = "select DISTINCT timet.date, timet.time_of_day_plan, timet.day_status,timet.final_estimation,own_estimation,timet.comment,timet.necessary,timet.for_tommorow, tasks.task_name, tasks.mark,
                    tasks.time, tasks.status,
                    tasks.details,tasks.note,tasks.timetable_id from tasks JOIN `timetables` timet ON timet.id = tasks.timetable_id where
                    tasks.timetable_id IN (select id from timetables where user_id = $id and date = '$date')
                      AND timet.user_id = $id LIMIT 10";
        $result = DB::select($query);
        //dd($result);
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

    public function getDayTime($id)
    {
        $currentDate = Carbon::today()->toDateString();
        $query = "select time_of_day_plan from timetables where user_id = $id and date = '$currentDate' ";
        $result = DB::select($query);
        if($result == []) return "uiyfg";

        return $result[0]->time_of_day_plan;
    }

    public function getFinalEstimation($id)
    {
        $currentDate = Carbon::today()->toDateString();
        $query = "select final_estimation from timetables where user_id = $id and date = '$currentDate' ";
        $result = DB::select($query);
        if($result == []) return "uiyfg";

        return $result[0]->final_estimation;
    }

    public function getOwnEstimation($id)
    {
        $currentDate = Carbon::today()->toDateString();
        $query = "select own_estimation from timetables where user_id = $id and date = '$currentDate' ";
        $result = DB::select($query);
        if($result == []) return "uiyfg";

        return $result[0]->own_estimation;
    }

    public function getNecessary($id)
    {
        $currentDate = Carbon::today()->toDateString();
        $query = "select necessary from timetables where user_id = $id and date = '$currentDate' ";
        $result = DB::select($query);
        if($result == []) return "uiyfg";

        return $result[0]->necessary;
    }

    public function getForTomorrow($id)
    {
        $currentDate = Carbon::today()->toDateString();
        $query = "select for_tommorow from timetables where user_id = $id and date = '$currentDate' ";
        $result = DB::select($query);
        if($result == []) return "uiyfg";

        return $result[0]->for_tommorow;
    }

    public function isWeekendAble($id)
    {
        /**
         * Получаю дни неджели.Похожусь в цикле по каждому дню и проверяю был ли уже взят выходной
         */
        date_default_timezone_set('Europe/Minsk');
        $daysCarbon = [];
        $days = [];
        $now = CarbonImmutable::now();
        $weekStartDate = $now->startOfWeek();//right
        $weekEndDate = $now->endOfWeek(); //right
        for($i = $weekStartDate; $i < $weekEndDate; $i = $i->addDay()){
            $daysCarbon[] = $i->toDate();
        }
        for($i = 0; $i < 7; $i++){
            $days[$i] = $daysCarbon[$i]->format('Y-m-d');
        }

        $query = "select day_status from timetables where user_id = $id and date BETWEEN '$days[0]'  AND '$days[6]'";
        $result = DB::select($query);
        foreach($result as $v){
            if($v->day_status == "Вых"){
                return false;
            }
        }

        return true;
    }

    public function isVacationAble($id)
    {
        /**
         * Получаю начало и конец месяца.Похожусь в цикле по каждому дню и проверяю был ли уже взят выходной
         */
        date_default_timezone_set('Europe/Minsk');
        $now = CarbonImmutable::now();
        $monthStartDate = $now->firstOfMonth()->toDateString(); //right
        $monthEndDate = $now->endOfMonth()->toDateString(); //right

        $query = "select day_status from timetables where user_id = $id and date BETWEEN '$monthStartDate'  AND '$monthEndDate'";
        $result = DB::select($query);
        //dd($result);
        foreach($result as $v){
            if($v->day_status == "Отпуск"){
                return false;
            }
        }

        return true;
    }
} 