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
        $ids  = $this->getIds();//Получаю id всех пользователей
        $date = Carbon::today()->toDateString();
        /*Теперь для каждого пользователя мне надо рассчитать итоговую оценку*/
        foreach ($ids as $id){
            //получаю последний timetable_id текущего юзера
            $currentTimetableId = function () use ($id, $date){
                $response = TimetableModel::where('user_id', $id)
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
                "final_time"       => $this->sumTime($timetableId),
                "final_estimation" => $finalMark,
                "own_estimation"   => 0.00,
                "date"             => Carbon::today()->toDateString(),
                "day_status"       => 3,
            ];

            $this->fillTimetablesTable($data, $ids);
        }
    }

    private function sumMarks($timetableId)
    {
        $today = Carbon::today()->toDateString();
        $response = (function () use ($today, $timetableId){
            $query = "SELECT mark  FROM tasks JOIN timetables ON tasks.timetable_id = timetables.id WHERE timetables.date = "."'$today'"."
                       AND tasks.timetable_id = $timetableId AND tasks.type = 4 OR tasks.type = 3
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
            $query2 = "SELECT SUM(mark) S2  FROM tasks  JOIN timetables T ON timetable_id = $timetableId WHERE T.date = "." '$today' "." AND type = 3 GROUP BY(tasks.id) WITH ROLLUP";
            $avgMark = DB::select($query);
            $avgMark2 = DB::select($query2);
            $avgMarkCount = count($avgMark) - 1;
            $avgMark = ($avgMark[array_key_last($avgMark)]->S / $avgMarkCount);
            if($avgMark2){
                $avgMarkCount2 = count($avgMark2) - 1;
                $avgMark2 = ($avgMark2[array_key_last($avgMark2)]->S2 / $avgMarkCount2);
                $avgMark += $avgMark2;
                $avgMark /= 2;
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

    private function fillTimetablesTable(array $data, array $ids)
    {
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
    }

    public function getIds()
    {
        $query = "SELECT id FROM users";
        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v){
            $ids[] = $v->id;
        }

        return $ids;
    }
}
