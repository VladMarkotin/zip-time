<?php

namespace App\Repositories;

use App\Models\TimetableModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EstimationRepository
{

    public function __construct()
    {
        $this->estimate();
    }

    private function estimate()
    {
        $ids  = $this->getIds();//Получаю id всех пользователей  с составленным на сегодня планом
        //Here I get ids of bad guys
        $badIds = $this->getBadIds();//получаю id тех юзеров, кто вообще не составил на сегодня план
        //end
        $date = Carbon::today()->toDateString();
        if(count($ids) != 0){
            /*Теперь для каждого пользователя мне надо рассчитать итоговую оценку*/
            foreach ($ids as $id){
                //получаю timetable_id текущего юзера на сегодня
                $currentTimetableId = function () use ($id, $date){
                    $response = TimetableModel::
                          where('user_id', $id)
                        ->where('date', $date)
                        ->pluck('id')
                        ->toArray();

                    return $response[0];
                };

                /*Here I have to check either guy */

                $timetableId = $currentTimetableId();
                $finalMark = $this->sumMarks($timetableId); //считаю оценку каждого юзера
                $data = [
                    "timetable_id"     => $timetableId,
                    "user_id"          => $id,
                    "final_time"       => ($finalMark >= 50) ? $this->sumTime($timetableId): '00:00',
                    "final_estimation" => $finalMark,
                    "own_estimation"   => 0.00,
                    "date"             => Carbon::today()->toDateString(),
                    "day_status"       => ($finalMark >= 50) ? 3 : -1,
                ];
                $this->fillTimetablesTable($data, $ids);
            }
        }
        if(count($badIds) != 0){
            /*Estimate lazy guys*/
            foreach ($badIds as $id){

                    $data = [
                        "user_id"          => $id,
                        "final_time"       => '00:00',
                        "final_estimation" => -101,
                        "own_estimation"   => -101,
                        "date"             => Carbon::today()->toDateString(),
                        "day_status"       => -1,
                    ];

                $this->fillTimetablesTable($data, $badIds, 1);
            }
        }
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

    private function sumMarks($timetableId)
    {
        $today = Carbon::today()->toDateString();
        $response = (function () use ($today, $timetableId){
            $query = "SELECT mark  FROM tasks JOIN timetables ON tasks.timetable_id = timetables.id WHERE timetables.date = "."'$today'"."
                       AND tasks.timetable_id = $timetableId AND tasks.type = 4
                       AND timetables.day_status = 2";
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
                        'comment'          => '',
                        'necessary'        => '',
                        'for_tomorrow'     => ''
                    ));
            }
        } else {
            foreach($ids as $id){
                $dataForDayPlanCreation["user_id"]          = $id;
                $dataForDayPlanCreation["date"]             = Carbon::today();
                $dataForDayPlanCreation["day_status"]       = -1;
                $dataForDayPlanCreation["final_estimation"] = 0;
                $dataForDayPlanCreation["own_estimation"]   = 0;
                TimetableModel::insert($dataForDayPlanCreation);
            }
        }

    }
}
