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

class HistRepository
{
    private $period = null;

    public function getHist(array $period)
    {
        //temp var! Later I will get it as element of $period array
        $period['direction'] = -1; //direction of movement (-1 - back, 1 - forward)
        $directionSign = function (array $period){
            return ($period['direction'] < 0) ? '<' : '>';
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

        return $response;
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
        $query = "SELECT  timetables.id as t_id, timetables.user_id, timetables.date, timetables.day_status,
                     timetables.final_estimation, timetables.own_estimation,
                    timetables.comment, tasks.id, tasks.hash_code, tasks.task_name, tasks.type, tasks.priority, tasks.details,
                     tasks.time, tasks.mark, tasks.note FROM timetables JOIN tasks ON timetables.id = tasks.timetable_id";
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
            $closedDays = $addClosedDays();
            $weekend    = $addWeekends();
            $withFailed = $addWithFailed();
            $withEmergency = $addWithEmergency();
            $query .= " WHERE timetables.date BETWEEN '".$this->period['from'] ."' AND '".$this->period['to']."'$closedDays $weekend $withFailed $withEmergency";
            $response = DB::select($query);
        }else{ //Here we take history on concrete day
            $query .=  " WHERE timetables.date = '".$this->period['date'] ."'";
            $response = DB::select($query);
        }
        $history = TransformHistTrait::transformData($response, $this->period);

        return $history;
    }
}
