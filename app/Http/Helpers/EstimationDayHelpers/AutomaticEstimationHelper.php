<?php
namespace App\Http\Helpers\EstimationDayHelpers;  


use Illuminate\Support\Facades\DB;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;
use App\Models\TimetableModel;
use Illuminate\Support\Facades\Log;

class AutomaticEstimationHelper
{
    /*Get estimate users who hasт`t created plan on today*/
    public static function estimateLazyGuys($timezone = 'Europe/Minsk')
    {
        $date  = GeneralHelper::getTodayDate();
        $now   = GeneralHelper::getNow();
        $query = "INSERT INTO timetables (user_id, date, day_status, time_of_day_plan, final_estimation, own_estimation, comment, necessary, for_tomorrow)
                    SELECT u.id, '$date', -1, '00:00', 0, 0, 'It looks like the day was wasted :(', '', ''
                        FROM users u
                            LEFT JOIN timetables t ON u.id = t.user_id AND t.date = '$date'
                                WHERE t.user_id IS NULL AND u.timezone = '$timezone'";
        

       DB::insert($query);
    }

    public static function estimateWeekendUsers($timezone = 'Europe/Minsk')
    {
        
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

    public static function getTimezoneFromTime($time)
    {
        $givenTime = strtotime($time);
        $abbr = date('T', $givenTime);
        Log::info($abbr);
        $timezone = new \DateTimeZone($abbr);
        $now = new \DateTime('now', $timezone);
        $offsetInSeconds = $timezone->getOffset($now);
        $timezoneName = timezone_name_from_abbr("", $offsetInSeconds, 0);
        //Log::info($timezoneName);
        return $timezoneName;
    }
}