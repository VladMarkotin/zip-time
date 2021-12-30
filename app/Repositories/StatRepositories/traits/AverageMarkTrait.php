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
            $query = $query = "SELECT AVG(final_estimation) avgMark FROM `timetables` WHERE final_estimation <> 0.00
                            AND (day_status = 3
                             OR  day_status = -1)
                            AND user_id = $data[id] ";
        } else{
            $query = "SELECT AVG(own_estimation) ownMark FROM `timetables` WHERE day_status = 3
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
            $query = "SELECT final_estimation fE FROM `timetables` WHERE final_estimation <> 0.00
                        AND user_id = $data[id] ";
        } else{
            $query = "SELECT own_estimation oE FROM `timetables` WHERE own_estimation <> 0.00 AND user_id = $data[id] ";
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

        return $median;
    }

    function getExtremum($period, $type = 1) //1-max, 2-min
    {
        $data['id'] = Auth::id();
        if($type == 1){
            $query = "SELECT MAX(final_estimation) maxMark FROM `timetables` WHERE user_id = $data[id]
                                                                               AND day_status = 3 ";
        } else{
            $query = "SELECT MIN(final_estimation) minMark FROM `timetables` WHERE user_id = $data[id]
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
}
