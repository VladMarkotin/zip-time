<?php
namespace App\Http\Helpers\EstimationDayHelpers;  


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use Illuminate\Support\Facades\Log;

class EstimationDayHelper
{
    public static function checkRequiredTasks($timetableId)
    {
            $query = "SELECT SUM(tasks.mark)/COUNT(tasks.id) result  FROM tasks JOIN timetables ON tasks.timetable_id = timetables.id
                       WHERE tasks.timetable_id = $timetableId AND tasks.type = 2";
            $result = DB::select($query);
            
            return ($result[0]->result < 99 && !is_null($result[0]->result)
                ? false
                : true);
    }

    
    /**
     * event: -1 -- lazy users
     * 1 -- weekend
     * 2 -- ready to be closed
     */
    public static function prepareData($event, array $params)
    {
        $preparedData = [
            'user_id' => Auth::id(),
            'time_of_day_plan' => self::sumTime(),
            'final_estimation' =>self::sumMarks(),
            'own_estimation' => -1,
            'date' => GeneralHelper::getTodayDate(),
            'comment' => $params['comment'],
            'day_status' => GeneralHelper::getDayStatus(),
            'necessary' => '',
            'for_tomorrow' => $params['for_tomorrow'],
            'updated_at' => Carbon::now(),
        ];
        switch ($event) {
            //day was failed
            case -1:
                break;
            //weekend    
            case 1:
                $preparedData['day_status'] = 1;
                $preparedData['final_estimation'] = 0;
                $preparedData['own_estimation'] = $params['own_estimation'];
                break;
            //work day    
            case 2:
                $preparedData['day_status'] = 3;
                $preparedData['own_estimation'] = $params['own_estimation'];
                break;
        }
        //Log::info(json_encode($preparedData));
        return $preparedData;
    }

    public static function sumTime($timetableId = null)
    {
        //this is for manual counting
        if (!$timetableId) {
            $query = "SELECT SEC_TO_TIME( SUM(TIME_TO_SEC (STR_TO_DATE(`time`, '%H:%i') ) ) ) AS Sum_Of_time FROM tasks WHERE `timetable_id` = ". GeneralHelper::getCurrentTimetableId();
            $timeOfPlan = DB::select($query);
        } else { //this is for automatic counting
            $query = "SELECT SEC_TO_TIME( SUM(TIME_TO_SEC (STR_TO_DATE(`time`, '%H:%i') ) ) ) AS Sum_Of_time FROM tasks WHERE `timetable_id` = $timetableId";
            $timeOfPlan = DB::select($query);
        }

        return $timeOfPlan[0]->Sum_Of_time;
    }

    public static function getTagsForTomorow($tags)
    {
        $tagsForTomorow = $tags
            ? implode(';', $tags)
            : ''; //need to move it into service class
        $tagsForTomorow = rtrim($tagsForTomorow, ';');

        return $tagsForTomorow;
    }

    public static function sumMarks($dayStatus = 2)
    {
        $today       = GeneralHelper::getTodayDate();
        $timetableId = GeneralHelper::getCurrentTimetableId();
        $dayStatus   = GeneralHelper::getDayStatus();
       
            $id = Auth::id();
            $query =
                "SELECT SUM(mark) S, COUNT(tasks.id) Q   FROM tasks JOIN timetables T ON tasks.timetable_id = T.id
                 WHERE T.date = " . " '$today' " .
                    " AND type = 4
                      AND T.user_id = $id
                    "; //GROUP BY(tasks.timetable_id) WITH ROLLUP
            $query2 =
                "SELECT SUM(mark) S2, COUNT(tasks.id) Q2  FROM tasks  JOIN timetables T ON timetable_id = T.id
                 WHERE T.date = " .
                " '$today' " .
                " AND type = 3 AND mark <> -1.00 AND T.user_id = $id ";
                //GROUP BY(tasks.timetable_id) WITH ROLLUP
                $avgMark = DB::select($query);
                $avgMark2 = DB::select($query2);
                $avgMarkCount = count($avgMark) - 1;
                if ($avgMark[array_key_last($avgMark)]->Q) {

                    $avgMark = $avgMark[array_key_last($avgMark)]->S / $avgMark[array_key_last($avgMark)]->Q;
                }
                if ($avgMark2[array_key_last($avgMark2)]->Q2) { 
                    $avgMark2 = $avgMark2[array_key_last($avgMark2)]->S2 / $avgMark2[array_key_last($avgMark2)]->Q2;
                    $avgMark += $avgMark2;
                    $avgMark /= 2;
                }
                //  Log::info(json_encode($avgMark));
                //  die;

            return $avgMark;
        
        //php artisan schedule:work

        return -1;
    }

    public static function checkRequiredJobs($timetableId)
    {
        //if there is at least 1 undone job, query will return -1
        $query = "
            SELECT IF(MIN(mark) = -1, -1, MIN(mark)) AS mark
            FROM tasks
            JOIN timetables ON tasks.timetable_id = timetables.id
            WHERE timetables.id = $timetableId AND tasks.type = 4;
        
        ";
        $minMark = DB::select($query);
        if ($minMark[0]->mark == -1) {
            return 0;
        }

        return 1;
    }
}
