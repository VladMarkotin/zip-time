<?php
namespace App\Http\Livewire\LWServices;


use App\Models\SavedTask;
use MathPHP\Statistics\Average;
use DB;
use Auth;

class TaskStatService
{
    private $sT = null;

    public static function getInfo($id)
    {
        //dd(Auth::id());
        $sT = SavedTask::where('id', $id)->get()->toArray(); //ok
        $requestData = [
            "hash"   => $sT[0]['hash_code'],
            "userId" => Auth::id()
        ];
        $data["hash"]       = $sT[0]['hash_code'];
        $data["avgMark"]    = self::getAvgMark($requestData);
        $data["totalTime"]  = self::getTotalTime($requestData);
        $data["medianMark"] = self::getMedianMark($requestData);
        $data["totalUse"]   = self::getTotalUse($requestData);
        $data["completed"]  = self::getCompletedFailedValue($requestData, 1);
        $data["undone"]     = self::getCompletedFailedValue($requestData, 0);
        
        $modifiedData = self::transformData($data);

        return $modifiedData;
    }

    private static function getTotalUse($data)
    {
        $query = "SELECT COUNT(id) TU FROM tasks WHERE hash_code = '". $data['hash'] ."' AND tasks.timetable_id
                   IN (SELECT timetables.id FROM timetables WHERE timetables.user_id = $data[userId])";
        //dd($query);
        $totalUse = DB::select($query);

        return $totalUse[0]->TU;
    } 

    private static function getTotalTime($data)
    {
        $query = "SELECT SEC_TO_TIME( SUM(TIME_TO_SEC (STR_TO_DATE(`time`, '%H:%i') ) ) ) AS Sum_Of_time
                    FROM tasks WHERE hash_code = '". $data['hash'] ."' AND tasks.timetable_id
                    IN (SELECT timetables.id FROM timetables WHERE timetables.user_id = $data[userId])";
        //dd($query);
        $timeOftask = DB::select($query);

        return $timeOftask[0]->Sum_Of_time;
    }

    private static function getAvgMark($data)
    {
        //Get avetage mark for saved task by hash code
        $query = "SELECT ROUND(AVG(mark),2) avg FROM `tasks` WHERE tasks.hash_code = '". $data['hash'] ."' 
                   AND mark <> -1.00 AND tasks.timetable_id
                      IN (SELECT timetables.id FROM timetables WHERE timetables.user_id = $data[userId])";
        $result = DB::select($query);
        //dd($result[0]->avg); 
        return $result[0]->avg;
    }

    private static function getMedianMark($data)
    {
        $query = "SELECT ROUND(mark, 2) mM FROM `tasks` WHERE mark <> -1.00 AND hash_code = '$data[hash]'
                   AND tasks.timetable_id
                     IN (SELECT timetables.id FROM timetables WHERE timetables.user_id = $data[userId])";
        $result = DB::select($query);
        $medianValues = [];
        foreach ($result as $v){
            $medianValues[] = $v->mM;
        }
        ($medianValues) ? $median = Average::median($medianValues) : $median = 0;
        $median = number_format($median, 2);
        
        return $median;
    }

    private static function getCompletedFailedValue($data, $flag = 1) //1-completed tasks,0-incomleted
    {
        $sign = ($flag) ? ">=": "<";
        $query = "SELECT COUNT(mark) cV FROM `tasks` WHERE mark ". $sign ." 50 AND
                     hash_code = '$data[hash]'
                    AND tasks.timetable_id
                    IN (SELECT timetables.id FROM timetables WHERE timetables.user_id = $data[userId])";
        $result = DB::select($query);

        return $result[0]->cV;
    }

    private static function transformData($data)
    {
        $keys = array_keys($data);
        
        $modifiedData = array_combine(
            $keys,
            array_map(function ($value, $key) {

                $transformData = function($data)
                {   
                    if (!isset($data)) {
                        $data = "00:00:00";
                    }
                    $dataArr = explode(':', $data);

                    $hours   = $dataArr[0];
                    $minutes = $dataArr[1];
                    $seconds = $dataArr[2];

                    $transformHours   = $hours . ((int) $hours !== 1 ? " hours" : " hour");
                    $transformMinutes = $minutes . ((int) $minutes !== 1 ? " minutes" : " minute");
                    $transformSeconds = $seconds . ((int) $seconds !== 1 ? " seconds" : " second");
                    
                    return "$transformHours $transformMinutes $transformSeconds";
                };

                switch ($key) {
                    case 'avgMark':
                    case 'medianMark':
                        if (isset($value)) return "$value%";
                        break;
                    case 'totalTime':
                        return $transformData($value);
                        break;
                    case 'totalUse':
                    case 'completed':
                    case 'undone':
                        return $value . ($value !== 1 ? " times" : " time");
                        break;
                    default:
                        return $value;
                }
            }, $data, $keys)
        );
        
        return $modifiedData;
    }

    
}