<?php
namespace App\Http\Helpers\EstimationDayHelpers;  


use Illuminate\Support\Carbon;

class AutomaticEstimationHelper
{
    /*Get id of users who has created plan on today*/
    public static function getIds()
    {
        $today = Carbon::today()->toDateString();
        $query =
            "SELECT users.id FROM users JOIN timetables ON users.id = timetables.user_id WHERE
                        timetables.day_status = 2 AND
                        timetables.date = '" .
            $today .
            "'";
        $idsArr = DB::select($query); //Array of all user`s id
        $ids = [];
        foreach ($idsArr as $v) {
            $ids[] = $v->id;
        }

        return $ids;
    }

    /*Get id of users who has`t created plan on today*/
    public static function getBadIds()
    {
        $today = Carbon::today()->toDateString();
        $query =
            "SELECT users.id FROM users WHERE
                        users.id NOT IN (select b.user_id
                            from timetables b
                               where b.date = '" .
            $today .
            "');
                        ";
        //dd($query);
        $idsArr = DB::select($query); //Array of all user`s id
        $badIds = [];
        foreach ($idsArr as $v) {
            $badIds[] = $v->id;
        }

        return $badIds;
    }

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
}