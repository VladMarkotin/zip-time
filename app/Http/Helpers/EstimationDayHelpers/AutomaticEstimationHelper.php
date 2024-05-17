<?php
namespace App\Http\Helpers\EstimationDayHelpers;  


use Illuminate\Support\Facades\DB;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use  App\Http\Helpers\EstimationDayHelpers\EstimationDayHelper;
use App\Models\TimetableModel;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AutomaticEstimationHelper
{
    /*Get estimate users who hasт`t created plan on today*/
    public static function estimateLazyGuysInTimezone($timezone = ['Europe/Minsk'])
    {
        $date  = GeneralHelper::getTodayDate();
        $now   = GeneralHelper::getNow();
        $in    = GeneralHelper::prepareSqlIn($timezone);
        $query = "INSERT INTO timetables (user_id, date, day_status, time_of_day_plan, final_estimation, own_estimation, comment, necessary, for_tomorrow)
                    SELECT u.id, '$date', -1, '00:00', 0, 0, 'It looks like the day was wasted :(', '', ''
                        FROM users u
                            LEFT JOIN timetables t ON u.id = t.user_id AND t.date = '$date'
                                WHERE t.user_id IS NULL AND u.timezone IN( '$in')";
        

       DB::insert($query);
    }

    public static function estimateIrresponsibleGuysInTimezone($timezone = ['Europe/Minsk'])
    {
        $date = GeneralHelper::getTodayDate();
        $in    = GeneralHelper::prepareSqlIn($timezone);
        //1. Find such users
        $query = "SELECT DISTINCT t.user_id
                    FROM timetables AS t
                        JOIN tasks t2 ON t.id = t2.timetable_id
                            JOIN users u ON t.user_id = u.id 
                                WHERE t.day_status = 2 AND t2.mark = -1 AND t.date = '$date' AND t2.type IN (4, 2) AND u.timezone IN( '$in') ";
        $userIds = DB::select($query);
        $userIdsAsArr = [];
        //Step 2: Update query for users with such id
        foreach ($userIds as $obj) {
            $userIdsAsArr[] = $obj->user_id;
        }
        if (count($userIdsAsArr)) {
            $userIdsAsStr = implode(',', $userIdsAsArr);
            $queryUpdate = "UPDATE timetables T0 SET T0.final_estimation = 0, T0.day_status = -1,  T0.own_estimation = 0 WHERE T0.user_id IN ($userIdsAsStr) AND T0.date='$date' ";
            DB::update($queryUpdate);
            //Log::info($queryUpdate);
        }

        return true;
    }

    public static function estimateWeekendUsersInTimezone($timezone = ['Europe/Minsk'])
    {
        $date = GeneralHelper::getTodayDate();
        $in   = GeneralHelper::prepareSqlIn($timezone);
        //1. Find such users
        $query = "SELECT DISTINCT t.user_id
                    FROM timetables AS t
                        JOIN tasks t2 ON t.id = t2.timetable_id
                            JOIN users u ON t.user_id = u.id 
                                WHERE t.day_status = 1 AND u.timezone IN( '$in') AND t.date='$date' ";
        $userIds = DB::select($query);
        $userIdsAsArr = [];
        //Step 2: Update query for users with such id
        foreach ($userIds as $obj) {
            $userIdsAsArr[] = $obj->user_id;
        }
        if (count($userIdsAsArr)) {
            $userIdsAsStr = implode(',', $userIdsAsArr);
            $queryUpdate = "UPDATE timetables T0 SET T0.own_estimation = 50 WHERE T0.user_id IN ($userIdsAsStr) ";
            DB::update($queryUpdate);
            //Log::info($queryUpdate);
        }
        
        return true;
    }

    /**
     * method counts final mark for all users 
     */
    public static function estimateUsersInCurrentTimezone($timezone = ['Europe/Minsk'])
    {
        $timezones = AutomaticEstimationHelper::getTimezonesForEstimation();
        $in    = GeneralHelper::prepareSqlIn($timezones);
        $date = GeneralHelper::getTodayDate();
        $query = "SELECT U.id ID, SUM(mark)/COUNT(mark) final_estimation    FROM tasks JOIN timetables T ON tasks.timetable_id = T.id JOIN users U ON T.user_id = U.id WHERE T.date = '$date'
                    AND T.day_status IN (1, 2)
                        AND tasks.mark > -1
                            AND type = 4
                                AND U.timezone IN('$in')  GROUP BY tasks.timetable_id, U.id WITH ROLLUP";

        $result = DB::select($query);
       
        //Log::info(json_encode($result));
        //Close user`s plans in timezone
        self::closeUsersPlans($result);
    }

    //do not need it
    public static function getWeekendIds()
    {
        $today = Carbon::today()->toDateString();
        $query =
            "SELECT users.id FROM users JOIN timetables ON users.id = timetables.user_id
                         WHERE timetables.day_status = 1
                         AND timetables.own_estimation = 0
                         AND timetables.date = '" .
            $today .
            "'";
        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v) {
            $ids[] = $v->id;
        }

        return $ids;
    }

    /**
     * event: -1 -- lazy users
     * 1 -- weekend
     * 2 -- ready to be closed
     */
    public static function prepareData($event, array $params)
    {
        $preparedData = [
            'user_id' => $params['id'],
            'final_time' => $params['final_time'],
            'final_estimation' => $params['final_estimation'],
            'own_estimation' => -1,
            'date' => Carbon::today()->toDateString(),
            'comment' => $params['comment'],
            'day_status' => $params['day_status'],
            'updated_at' => Carbon::now(),
        ];
        switch ($event) {
            case -1:

                break;
        }

        return $preparedData;
    }

    public static function getTimezonesForEstimation()
    {
        $currentTimezone = [];
        $timezones = self::getUniqueTimezones();
        foreach ($timezones as $timezone) {
            $time = GeneralHelper::getNow($timezone);    
            if ($time->hour === 22) { //23 ВЕРНУТЬ!
                array_push($currentTimezone, $time->getTimezone());   // if hour in that timezone == 23:59(end of day) push user to array
            }
        }

        return $currentTimezone;
    }

    public static function getUniqueTimezones()
    {
        return  User::distinct('timezone')->pluck('timezone'); // the unique timezones in database
    }

    //----------------
    private static function closeUsersPlans(array $data)
    {
        Log::info('closeUsersPlans');
        foreach ($data as $v) {
            if ($v->ID) {
                //1. get current timetable id for this user
                $timetableId = GeneralHelper::getCurrentTimetableId(['id' => $v->ID]);
                //2.count time for timetable`s of ID
                $time = EstimationDayHelper::sumTime($timetableId);
                //3.Updating day info for users. Apply queues later!
                TimetableModel::where('id', $timetableId)->update([
                    'time_of_day_plan' => $time,
                    'day_status' => 3,
                    'final_estimation' =>  $v->final_estimation,
                    'own_estimation' =>  $v->final_estimation,
                    'comment' => 'Closed automaticaly',
                    'updated_at' => DB::raw('CURRENT_TIMESTAMP(0)'),
                ]);
            } else {
                continue;
            }
        }
    }

}