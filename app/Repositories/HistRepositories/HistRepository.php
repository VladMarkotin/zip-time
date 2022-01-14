<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 29.10.2021
 * Time: 13:12
 */
namespace App\Repositories\HistRepositories;


use Illuminate\Support\Facades\DB;
use App\Repositories\HistRepositories\traits\TransformHistTrait;

class HistRepository
{
    private $period = null;

    public function getHist(array $period)
    {
        $this->period = $period;
        /*It means that we have time period NOT a concrete date*/
        if(!isset($period["date"])){
            $response     = $this->getDataFromDB();
        }else{ //we got concrete date
           $response = $this->getDataFromDB(1);
        }


        return $response;
    }

    private function getDataFromDB($flag = 0)
    {
        $query = "SELECT  timetables.id, timetables.user_id, timetables.date, timetables.day_status, timetables.final_estimation, timetables.own_estimation,
                    timetables.comment, tasks.id, tasks.hash_code, tasks.task_name, tasks.type, tasks.priority, tasks.details,
                     tasks.time, tasks.mark, tasks.note FROM timetables JOIN tasks ON timetables.id = tasks.timetable_id";
        if(!$flag){
            $_this = $this;
            $addClosedDays = function () {
                return " AND timetables.day_status = 3 ";
            };
            $addWeekends = function () use ($_this){
                $query = "";
                if($this->period['with_weekend']){
                    $query = " OR timetables.day_status = 1 ";
                }

                return $query;
            };
            $addWithFailed = function () use ($_this){
                $query = "";
                if($this->period['with_weekend']){
                    $query = " OR timetables.day_status = -1 ";
                }

                return $query;
            };
            $closedDays = $addClosedDays();
            $weekend    = $addWeekends();
            $withFailed = $addWithFailed();
            $query .= " WHERE timetables.date BETWEEN '".$this->period['from'] ."' AND '".$this->period['to']."'$closedDays $weekend $withFailed";
            $response = DB::select($query);
        }else{ //Here we take history on concrete day
            $query .=  " WHERE timetables.date = '".$this->period['date'] ."'";
            $response = DB::select($query);
        }
        $history = TransformHistTrait::transformData($response, $this->period);

        return $history;
    }
} 