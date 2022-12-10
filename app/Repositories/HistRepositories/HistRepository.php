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
                          FROM timetables JOIN tasks
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
            $query        .= " WHERE timetables.date BETWEEN '".$this->period['from'] .
            "' AND '".$this->period['to']."' AND timetables.day_status IN (-1,0,1,3) 
            AND timetables.user_id = $userId";
            $response      = DB::select($query);
            //die(var_dump($response));
        }else{ //Here we take history on concrete day
            $query        .=  " WHERE timetables.date = '".$this->period['date'] ."'";
            $response      = DB::select($query);
        }
        $history           = TransformHistTrait::transformData($response, $this->period);

        //dd( $history   );
       return $history;
    }
}
