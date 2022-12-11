<?php

namespace App\Repositories;

use App\Models\TimetableModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\RatingService;

class EstimationRepository
{
   
    private $userRatings   = null;

    public function __construct( RatingService $userRatings)
    {
        $this->userRatings = $userRatings;
    }


    /*This method will be executing automaticly for all users with unclosed plan in the end of the day (23:59) */
    public function estimate()
    { 
       
        $ids  = $this->getIds();//Получаю id всех пользователей  с составленным на сегодня планом
        //Here I get all weekend guys
        $weekendIds = $this->getWeekendIds();
        //Here I get ids of bad guys
        $badIds = $this->getBadIds();//получаю id тех юзеров, кто вообще не составил на сегодня план
        //end
        $date = Carbon::today()->toDateString();
        if(count($ids) != 0){
           
            /*Count final mark for every user with plan*/
            foreach ($ids as $id){
                //get timetable_id of current user for today
                $currentTimetableId = function () use ($id, $date){
                    $response = TimetableModel::
                          where('user_id', $id)
                        ->where('date', $date)
                        ->where('day_status', 2)
                        ->pluck('id')
                        ->toArray();

                    return $response[0];
                };

                $timetableId = $currentTimetableId();
                $finalMark = $this->sumMarks($timetableId); //считаю оценку каждого юзера
                $data = [
                    "timetable_id"     => $timetableId,
                    "user_id"          => $id,
                    "final_time"       => ($finalMark >= 50) ? $this->sumTime($timetableId): '00:00',
                    "final_estimation" => ($finalMark >= 50) ? $finalMark : 0,
                    "own_estimation"   => $finalMark,
                    "comment"          => "Closed automatically",
                    "date"             => Carbon::today()->toDateString(),
                    "day_status"       => ($finalMark >= 50) ? 3 : -1,
                    "updated_at"       => Carbon::now(),
                ];

                ($finalMark >= 50) ?  $this->userRatings->estimateActiveDayrating(2) :  $this->userRatings->estimateActiveDayrating(0);
               
                $this->fillTimetablesTable($data, $ids);
            }

          
        }
        if(count($badIds) != 0){
           
            /*Estimate lazy guys*/
            foreach ($badIds as $id){

                    $data = [
                        "user_id"          => $id,
                        "final_time"       => '00:00',
                        "final_estimation" => -1,
                        "own_estimation"   => -1,
                        "date"             => Carbon::today()->toDateString(),
                        "comment"          => "It looks like the day was wasted :(",
                        "day_status"       => -1,
                        "updated_at"       => Carbon::now(),
                    ];

                $this->userRatings->estimateLazyDayrating(0);
                $this->fillTimetablesTable($data, $badIds, 1);
            }
          
        }
        if(count($weekendIds) > 0){
          
            foreach ($weekendIds as $id){
                $currentTimetableId = function () use ($id, $date){
                    $response = TimetableModel::
                    where('user_id', $id)
                        ->where('date', $date)
                        ->where('day_status', 1)
                        ->pluck('id')
                        ->toArray();

                    return $response[0];
                };

                /*Here I have to check either guy */

                $timetableId = $currentTimetableId();
                $data = [
                    "timetable_id"     =>  $timetableId,
                    "user_id"          => $id,
                    "final_time"       => $this->sumTime($timetableId),
                    "final_estimation" => 0,
                    "own_estimation"   => 50,
                    "date"             => Carbon::today()->toDateString(),
                    "day_status"       => 1,
                    'comment'          => 'Closed automatically at '.Carbon::now()->toDateTimeString(),
                    "updated_at"       => Carbon::now(),
                ];
                $this->userRatings->estimateActiveDayrating(1);
                $this->fillTimetablesTable($data, $weekendIds, 0);
            }

          
        }
    }

    /*This method will be executing for concrete user on demand*/
    public function closeDay(array $data)
    {
        $currentTimetableId = function () use ($data){
            $response = TimetableModel::where('user_id', $data['user_id'])
                ->where('date', $data['date'])
                ->pluck('id')
                ->toArray();

            return $response[0];
        };
        $timetableId        = $currentTimetableId();
        $getDayStatus       = function () use ($timetableId){
            $response = TimetableModel::where('id', $timetableId)
                ->pluck('day_status')
                ->toArray();

            return $response[0];
        };
        $tagsForTomorow = ($data['tomorow']) ? implode($data['tomorow'], ';') : '';//need to move it into service class
        $tagsForTomorow = rtrim($tagsForTomorow, ";");
        if($getDayStatus() == 1){
            DB::table('timetables')->where( [ ['id', '=', $timetableId], ["user_id", '=', $data['user_id']] ] )
                ->update(array(
                    'time_of_day_plan' => $this->sumTime($timetableId), //time of plan info. Fix it later!!
                    'final_estimation' => 0, //0 признак того, что день под статусом Вых
                    'own_estimation'   => $data['mark'],
                    'day_status'       => 1,
                    'comment'          => $data['comment'],
                    'necessary'        => '',
                    'for_tomorrow'     => $tagsForTomorow,
                    "updated_at"       => Carbon::now(),
                ));

            return true;
        }
        $finalMark = $this->sumMarks($timetableId); //считаю оценку каждого юзера
        //Здесь надо проверить выполнены ли обязательные задачи, если они есть
        $areRequiredTasksComplete = $this->checkRequiredTasks($timetableId);

        if( ($finalMark >= 50) && ($areRequiredTasksComplete)){
            $data = [
                "id"               => $timetableId,
                "user_id"          => $data['user_id'],
                "time_of_day_plan" => ($finalMark >= 50) ? $this->sumTime($timetableId): '00:00',
                "final_estimation" => $finalMark,
                "own_estimation"   => $data['mark'],
                "comment"          => $data['comment'],
                "date"             => Carbon::today()->toDateString(),
                "day_status"       => ($finalMark >= 50) ? 3 : -1,
                "updated_at"       => Carbon::now(),
            ];
            /*This code could be placed in own method for optimization later*/
            DB::table('timetables')->where([ ['id', '=', $data['id']], ["user_id", '=', $data['user_id'] ] ] )
                ->update(array(
                    'time_of_day_plan' => $data['time_of_day_plan'], //time of plan info. Fix it later!!
                    'final_estimation' => $data['final_estimation'], //-2 - признак того, что день под статусом Вых
                    'own_estimation'   => $data['own_estimation'],
                    'day_status'       => $data["day_status"],
                    'comment'          => $data['comment'],
                    'necessary'        => '',
                    'for_tomorrow'     => $tagsForTomorow,
                    "updated_at"       => Carbon::now(),
                ));

            return true;
        }

        return false;
    }

    public function getEmergencyCall(array $data)
    {
        $mutable = Carbon::now();
        $id = Auth::id();
        $dataForDayPlanCreation["user_id"]          = $id;
        $dataForDayPlanCreation["date"]             = $mutable;//->add(1, 'day');
        $dataForDayPlanCreation["day_status"]       = 0;
        $dataForDayPlanCreation["final_estimation"] = 0;
        $dataForDayPlanCreation["own_estimation"]   = 0;
        $dataForDayPlanCreation["comment"]          = $data['comment'];
        $dataForDayPlanCreation["updated_at"]       = DB::raw('CURRENT_TIMESTAMP(0)');
        for($i = 0; $i < $data['term']; $i++){
            if(!$i){
                DB::table('timetables')->where([ ['date', '=', Carbon::today()->toDateString()], ["user_id", '=', $id ] ] )
                    ->update(array(
                        'time_of_day_plan' => '00:00',
                        'final_estimation' => 0,
                        'own_estimation'   => 0,
                        'day_status'       => 0,
                        'comment'          => $data['comment'],
                        'necessary'        => '',
                        'for_tomorrow'     => ''
                    ));
            }
            TimetableModel::insert($dataForDayPlanCreation);
            $dataForDayPlanCreation["date"] = $mutable->add(1, 'day');
        }

        return $data;
    }

    /*Get id of users who has created plan on today*/
    public function getIds()
    {
        $today = Carbon::today()->toDateString();
        $query = "SELECT users.id FROM users JOIN timetables ON users.id = timetables.user_id WHERE
                        timetables.day_status = 2 AND
                        timetables.date = '". $today."'";
        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v){
            $ids[] = $v->id;
        }

        return $ids;
    }

    /*This method returns all final info about day: final_mark, own_mark, comment */
    public function getFinalInfoForTheDay(array $data)
    {
        $query = "SELECT time_of_day_plan, final_estimation, own_estimation, comment FROM timetables WHERE
                   date = '".$data['date']."' AND user_id = ".$data['id']."";
        $response = DB::select($query);

        return $response;
    }

    /*Get id of users who has`t created plan on today*/
    private function getBadIds()
    {
        $today = Carbon::today()->toDateString();
        $query = "SELECT users.id FROM users WHERE
                        users.id NOT IN (select b.user_id
                            from timetables b
                               where b.date = '". $today."');
                        ";
        //dd($query);
        $idsArr = DB::select($query); //Array of all user`s id
        $badIds = [];
        foreach ($idsArr as $v){
            $badIds[] = $v->id;
        }

        return $badIds;
    }

    private function getWeekendIds()
    {
        $today = Carbon::today()->toDateString();
        $query = "SELECT users.id FROM users JOIN timetables ON users.id = timetables.user_id
                         WHERE timetables.day_status = 1
                         AND timetables.own_estimation = 0
                         AND timetables.date = '". $today."'";
        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v){
            $ids[] = $v->id;
        }

        return $ids;
    }

    private function sumMarks($timetableId, $dayStatus = 2)
    {
        $today = Carbon::today()->toDateString();
        $response = (function () use ($today, $timetableId, $dayStatus){
            $taskType = 4;//
            $query = "SELECT mark  FROM tasks JOIN timetables ON tasks.timetable_id = timetables.id WHERE timetables.date = "."'$today'"."
                       AND tasks.timetable_id = $timetableId AND tasks.type = 4
                       AND timetables.day_status = $dayStatus";
            //die($query); //empty in weekend
            $marks = DB::select($query);
            foreach ($marks as $m){
                foreach($m as $mark){
                    if($mark == -1){
                        return 0;
                    }
                }

            }

            return 1;
        });
        $r = $response();
        if($r){

            $query  = "SELECT SUM(mark) S   FROM tasks JOIN timetables T ON timetable_id = $timetableId WHERE T.date = "." '$today' "." AND type = 4 GROUP BY(tasks.id) WITH ROLLUP";
            $query2 = "SELECT SUM(mark) S2  FROM tasks  JOIN timetables T ON timetable_id = $timetableId WHERE T.date = "." '$today' "." AND type = 3 AND mark <> -1.00 GROUP BY(tasks.id) WITH ROLLUP";
            $avgMark = DB::select($query);
            $avgMark2 = DB::select($query2);
            $avgMarkCount = count($avgMark) - 1;
            $avgMark = ($avgMark[array_key_last($avgMark)]->S / $avgMarkCount);
            if($avgMark2){
                $avgMarkCount2 = count($avgMark2) - 1; //It has to be 2 or more unrequired tasks to use them
                if($avgMarkCount2 > 1){
                    $avgMark2 = ($avgMark2[array_key_last($avgMark2)]->S2 / $avgMarkCount2);
                    $avgMark += $avgMark2;
                    $avgMark /= 2;
                }
            }

            return $avgMark;
        }
        //php artisan schedule:work

        return -1;
    }

    private function sumTime($timetableId)
    {
        $query = "SELECT SEC_TO_TIME( SUM(TIME_TO_SEC (STR_TO_DATE(`time`, '%H:%i') ) ) ) AS Sum_Of_time FROM tasks WHERE `timetable_id` = $timetableId";
        $timeOfPlan = DB::select($query);

        return $timeOfPlan[0]->Sum_Of_time;
    }

    private function checkRequiredTasks($timetableId)
    {
        $response = (function () use ($timetableId){
            $query = "SELECT SUM(tasks.mark)/COUNT(tasks.id) result  FROM tasks JOIN timetables ON tasks.timetable_id = timetables.id
                       WHERE tasks.timetable_id = $timetableId AND tasks.type = 2";
            $result = DB::select($query);
            //die(var_dump($result));
            return (($result[0]->result < 99) && (!is_null($result[0]->result))) ? false: true;
        });

        return $response();
    }

    private function fillTimetablesTable(array $data, array $ids, $badFlag = 0)
    {
        if(!$badFlag){
            foreach($ids as $id){
                DB::table('timetables')->where([ ['id', '=', $data['timetable_id']], ["user_id", '=', $data['user_id'] ] ] )
                    ->update(array(
                        'time_of_day_plan' => $data['final_time'], //time of plan info. Fix it later!!
                        'final_estimation' => $data['final_estimation'], //-2 - признак того, что день под статусом Вых
                        'own_estimation'   => $data['own_estimation'],
                        'day_status'       => $data["day_status"],
                        'comment'          => $data['comment'],
                        'necessary'        => '',
                        'for_tomorrow'     => '',
                        "updated_at"       => DB::raw('CURRENT_TIMESTAMP(0)'),
                    ));
            }
        } else {
            foreach($ids as $id){
                $dataForDayPlanCreation["user_id"]          = $id;
                $dataForDayPlanCreation["date"]             = Carbon::today();
                $dataForDayPlanCreation["day_status"]       = -1;
                $dataForDayPlanCreation["final_estimation"] = 0;
                $dataForDayPlanCreation["own_estimation"]   = 0;
                $dataForDayPlanCreation["comment"]          = $data['comment'];
                $dataForDayPlanCreation["updated_at"]       = DB::raw('CURRENT_TIMESTAMP(0)');
                TimetableModel::insert($dataForDayPlanCreation);
            }
        }

    }
}
