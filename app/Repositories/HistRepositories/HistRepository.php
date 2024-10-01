<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 29.10.2021
 * Time: 13:12
 */
namespace App\Repositories\HistRepositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\HistRepositories\traits\TransformHistTrait;
use Carbon\Carbon;
use App\Models\Preplan;

class HistRepository
{
    private $period  = null;
    private $preplan = null;

    public function __construct(Preplan $preplan)
    {
        $this->preplan = $preplan;
    }

    public function getHist(array $period)
    {
        //direction of movement (-1 - back, 1 - forward)
        $directionSign = function (array $period){
            if($period['direction'] < 0){
                return '<';
            }elseif($period['direction'] == 0){
                return '=';
            }else{
                return '>';
            }
        };
        $this->period = $period;
        $response     = [];
        /*It means that we have time period NOT a concrete date*/
        if(!isset($period["date"])){
            $response     = $this->getDataFromDB();
        }else{ //we got concrete date
            //check whether we have plan on this date
            $data['id']        = Auth::id();
            $data['date']      = $period['date'];
            $data['direction'] = $directionSign($period);

            //find quantity of plans according to date
            $userHistLength = $this->userHistLength($data);
            if($this->doWeHaveHist(['currentDate' => $period['date'] ])) {
                $response = $this->getDataFromDB(1);
            }
            $response['histLength'] = $userHistLength;
        }

        $futureDates = $this->getFutureDatesInCurrentMonth($period);
        if (count($futureDates)) {
            $futurePlans = $this->getFuturePlans($futureDates);
            $response["plans"] = [...$response["plans"], ...$futurePlans];
        }
        
        return $response;
    }

    private function getFutureDatesInCurrentMonth($period)
    {   
        $isNotLate = function($checkDay, $referenceDay) {
            return ($checkDay->isBefore($referenceDay)) || ($checkDay->isSameDay($referenceDay));
        };

        $getStartDay = function($today, $firstDayOfMonth) use($isNotLate) {
            $isTodayFirst = $today->isSameDay($firstDayOfMonth); 

            if (!$isNotLate($today, $firstDayOfMonth) || $isTodayFirst) {
                return $today->copy()->addDay();
            };
            
            return $firstDayOfMonth->copy();
        };
        //Мне необходимо выводить препланы начиная со следующего дня после сегодняшней даты
        //isNotLate нужно для того что бы не выводить пропущенные дни в текущем месяце
        //$isTodayFirst необходма для тех случаев, когда сегодняшняя дата приходится на 1е число месяца

        $firstDayOfMonth  = Carbon::createFromFormat('Y-m-d', $period["from"]);
        $lastDayOfMonth   = Carbon::createFromFormat('Y-m-d', $period["to"]);
        $today            = Carbon::createFromFormat('Y-m-d', $period["today"]);

        if ($today->isAfter($lastDayOfMonth)) {
            return [];
        }

        $startDay = $getStartDay($today, $firstDayOfMonth); //определяю начиная от какого дня мне надо выводить препланы

        for ($startDay; $isNotLate($startDay, $lastDayOfMonth); $startDay->addDay()) {
            $dates[] = $startDay->toDateString();
        }
        return $dates;

    }

    private function getFuturePlans($futureDates)
    {
        $user_id = Auth::id();
        
        $preplans = $this->preplan::where("user_id", $user_id)->whereIn("date", $futureDates)->get()->toArray();

        $transformedPreplans = [];
        foreach($preplans as $preplan) {
            $transformedPreplans[$preplan["date"]] = $preplan;
        }

        $transformedFuturePlans = [];
        foreach($futureDates as $futureDate) {
            if(array_key_exists($futureDate, $transformedPreplans)) {
                $currentDayData   = $transformedPreplans[$futureDate];
                $currentDayStatus = $currentDayData["day_status"];
                $tasks = json_decode($currentDayData["jsoned_tasks"]);

                $tasks = array_map(function($taskData) {
                    $task = [
                        "hashCode"  => $taskData->hash,
                        "taskName"  => $taskData->taskName,
                        "mark"      => '',
                    ];
                    return (object) $task;
                }, $tasks);
                
                $transformedFuturePlans[$futureDate] = [
                    "dayStatus" => $currentDayStatus,
                    "tasks"     => $tasks,
                ];

                continue;
            }
            $transformedFuturePlans[$futureDate] = ["dayStatus" => 4]; //код для обозначения дня в будущем на который нету ничего не запланировано
        }
        return $transformedFuturePlans;
    }

    private function doWeHaveHist(array $data) //$data = ['currentDate'=>'','timeDirection'=>'<|>']
    {
        $query = "SELECT COUNT(date) flag FROM `timetables` WHERE date =
                   '{$data['currentDate']}'";
        $response = DB::select($query);
        $histLength = $response[0]->flag;

        return $histLength;
    }

    private function userHistLength(array $data)
    {
        $query = "SELECT COUNT(id) flag FROM timetables WHERE user_id = $data[id]
                    AND date $data[direction] '$data[date]' ";
        $response = DB::select($query);

        return $response[0]->flag;
    }

    private function getDataFromDB($flag = 0)
    {
        $query = "SELECT  timetables.id as timetableId,
                          timetables.user_id AS userId,
                          timetables.date,
                          timetables.day_status dayStatus,
                          timetables.final_estimation dayFinalMark,
                          timetables.own_estimation AS dayOwnMark,
                          timetables.comment AS comment,
                          tasks.id taskId,
                          tasks.hash_code hashCode,
                          tasks.task_name taskName,
                          tasks.type AS type, 
                          tasks.priority AS priority, 
                          tasks.details AS details,
                          tasks.time AS time, 
                          tasks.mark mark, 
                          tasks.note notes 
                          FROM timetables LEFT JOIN tasks
                      ON timetables.id = tasks.timetable_id";
        if(!$flag){
            $addClosedDays = function () {
                return " AND timetables.day_status = 3 ";
            };
            $addWeekends = function (){
                $query = "";
                if($this->period['with_weekend']){
                    $query = " OR timetables.day_status = 1 ";
                }

                return $query;
            };
            $addWithFailed = function (){
                $query = "";
                if($this->period['with_weekend']){
                    $query = " OR timetables.day_status = -1 ";
                }

                return $query;
            };
            $addWithEmergency = function (){
                $query = "";
                if($this->period['with_weekend']){
                    $query = " OR timetables.day_status = 0 ";
                }

                return $query;
            };
            $closedDays    = $addClosedDays();
            $weekend       = $addWeekends();
            $withFailed    = $addWithFailed();
            $withEmergency = $addWithEmergency();
            $userId        = Auth::id();
            if(isset($this->period['from']['date'])) {
                $period = $this->period['from']['date'];
            } else {
                $period = $this->period['from'];
            }
            $query        .= " WHERE timetables.date BETWEEN '".$period .
            "' AND '".$this->period['to']."' AND timetables.day_status IN (-1,0,1,3) 
            AND timetables.user_id = $userId ORDER BY time DESC, priority DESC";
            $response      = DB::select($query);
        }else{ //Here we take history on concrete day
            $query        .=  " WHERE timetables.date = '".$this->period['date'] ."'";
            $response      = DB::select($query);
        }
        $history           = TransformHistTrait::transformData($response, $this->period);

        return $history;
    }
}
