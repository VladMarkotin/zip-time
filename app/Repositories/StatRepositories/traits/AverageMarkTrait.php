<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 28.12.2021
 * Time: 7:43
 */
namespace App\Repositories\StatRepositories\traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MathPHP\Statistics\Average;

trait AverageMarkTrait
{
    /*Получает среднюю оценку*/
    function getAvgMark($period, $type = 1)
    {
        $data['id'] = Auth::id();
        if($type == 1){
            $query = $query = "SELECT ROUND(AVG(final_estimation),2) avgMark FROM `timetables` WHERE final_estimation <> 0.00
                            AND (day_status = 3
                             OR  day_status = -1)
                            AND user_id = $data[id] ";
        } else{
            $query = "SELECT ROUND(AVG(own_estimation), 2) ownMark FROM `timetables` WHERE day_status = 3
                              AND own_estimation <> 0.00
                              AND user_id = $data[id] ";
        }

        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        } else{
            $query .= "AND date = '$period' ";
        }
        $response = DB::select($query);
        if($type == 1){
            $mark = $response[0]->avgMark;
        } else{
            $mark = $response[0]->ownMark;
        }
        if(is_null($mark)) { $mark = 0; }

        return $mark;
    }

    function getMedianValue($period, $type = 1) //type=1-final_estimation, type=2-own_estimation
    {
        $data['id'] = Auth::id();
        if($type == 1){
            $query = "SELECT ROUND(final_estimation, 2) fE FROM `timetables` WHERE final_estimation <> 0.00
                        AND user_id = $data[id] ";
        } else{
            $query = "SELECT ROUND(own_estimation, 2) oE FROM `timetables` WHERE own_estimation <> 0.00 AND user_id = $data[id] ";
        }
        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        } else{
            $query .= "AND date = '$period' ";
        }
        $response = DB::select($query);
        $medianValues = [];
        foreach ($response as $v){
            ($type == 1) ? $medianValues[] = $v->fE
                          : $medianValues[] = $v->oE;
        }
        ($medianValues) ? $median = Average::median($medianValues) : $median = 0;
        $median = number_format($median, 2);

        return $median;
    }

    function getExtremum($period, $type = 1) //1-max, 2-min
    {
        $data['id'] = Auth::id();
        if($type == 1){
            $query = "SELECT ROUND(MAX(final_estimation),2) maxMark FROM `timetables` WHERE user_id = $data[id]
                                                                               AND day_status = 3 ";
        } else{
            $query = "SELECT ROUND(MIN(final_estimation), 2) minMark FROM `timetables` WHERE user_id = $data[id]
                                                                               AND day_status = 3";
        }

        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        } else{
            $query .= "AND date = '$period' ";
        }
        $response = DB::select($query);
        ($type == 1) ? $mark = $response[0]->maxMark : $mark = $response[0]->minMark;
        if(is_null($mark)){ $mark = 0 ;}

        return $mark;
    }

    function getTotalTime($period)
    {
        $data['id'] = Auth::id();
        $query = "SELECT SEC_TO_TIME(ROUND(SUM(TIME_TO_SEC(time_of_day_plan)))) total_time FROM `timetables` WHERE user_id = $data[id] AND day_status = 3 ";
        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        }
        $response = DB::select($query);

        return $response[0]->total_time;
    }
}
