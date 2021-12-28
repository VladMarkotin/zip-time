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
    function getAvgMark($period)
    {
        $data['id'] = Auth::id();
        $query = $query = "SELECT AVG(final_estimation) avgMark FROM `timetables` WHERE final_estimation <> 0.00
                            (AND day_status = 3
                             OR  day_status = -1)
                            AND user_id = $data[id] ";
        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        } else{
            $query .= "AND date = '$period' ";
        }
        $response = DB::select($query);

        return $response[0]->avgMark;
    }

    /*Получает среднюю личную оценку*/
    function getOwnAvgMark($period)
    {
        $data['id'] = Auth::id();
        $query = $query = "SELECT AVG(own_estimation) ownMark FROM `timetables` WHERE day_status = 3
                              AND own_estimation <> 0.00
                              AND user_id = $data[id] ";
        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        } else{
            $query .= "AND date = '$period' ";
        }
        $response = DB::select($query);

        return $response[0]->ownMark;
    }

    function getMedianValue($period)
    {
        $data['id'] = Auth::id();
        $query = $query = "SELECT final_estimation fE FROM `timetables` WHERE final_estimation <> 0.00 AND user_id = $data[id] ";
        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        } else{
            $query .= "AND date = '$period' ";
        }
        $response = DB::select($query);
        foreach ($response as $v){
            $medianValues[] = $v->fE;
        }
        $median = Average::median($medianValues);

        return $median;
    }

    function getMaxMark($period)
    {
        $data['id'] = Auth::id();
        $query = "SELECT MAX(final_estimation) maxMark FROM `timetables` WHERE user_id = $data[id] ";
        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        } else{
            $query .= "AND date = '$period' ";
        }
        $response = DB::select($query);

        return $response[0]->maxMark;
    }

    function getMinMark($period)
    {
        $data['id'] = Auth::id();
        $query = "SELECT MIN(final_estimation) minMark FROM `timetables` WHERE user_id = $data[id] ";
        if(is_array($period)){
            $query .= " AND date BETWEEN '$period[from]' AND '$period[to]' ";
        } else{
            $query .= "AND date = '$period' ";
        }
        $response = DB::select($query);

        return $response[0]->minMark;
    }


} 