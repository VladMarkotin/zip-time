<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use UserGroupTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait GetWorserUsersTrait
{
    //Have to count % who didn`t create plan for today in user`s group
    public static function getData(array $data, array $ratingData)
    {
        $results = [];
        $results['QuantityInGroup'] = $ratingData['quntityInGroupExcludingOneself'] ?? 0;
        $isValidDailyPlan = self::getStatusOfTheDailyPlanIsValid();
    
        if (!empty($ratingData['group'])) {
            $results['QuantityOfUsersFailed'] = self::getQuantityOfUsersFailed($data, $ratingData);
            $results['QuantityOfUsersWithNoPlan'] = self::getQuantityOfUsersWithNoPlan($data, $ratingData);
        } else {
            $results['QuantityOfUsersFailed'] = self::getQuantityOfUsersFailed($data, []);
            $results['QuantityOfUsersWithNoPlan'] = self::getQuantityOfUsersWithNoPlan($data, []);
        }
        
        $totalUsers = $results['QuantityOfUsersFailed'] + $results['QuantityOfUsersWithNoPlan'];
        
        if ($isValidDailyPlan && $results['QuantityInGroup'] > 0) {
            $percentOfWorseUsers = ($totalUsers / $results['QuantityInGroup']) * 100;
        } else {
            $percentOfWorseUsers = 0;
        }
    
        Log::info("Total Users: " . $totalUsers);
        Log::info("Quantity In Group: " . $results['QuantityInGroup']);
        Log::info("Percent of Worse Users: " . $percentOfWorseUsers);
    
        return $percentOfWorseUsers;
    }
    
    public static function getQuantityOfUsersWithNoPlan(array $data, array $ratingData)
    {
        $date   = Carbon::today()->toDateString();
        $userId = Auth::id();
        
        if ($ratingData) {
            $query = "SELECT COUNT(u.id) quantity 
                FROM `users` u 
                LEFT JOIN timetables t ON u.id = t.user_id AND t.date = '$date' 
                WHERE t.user_id IS NULL
                AND u.id != $userId
                AND u.rating
                BETWEEN ".$ratingData['group']->from ." AND ". $ratingData['group']->to;
            $result = DB::select($query);

            return (isset($result[0]) ? $result[0]->quantity : 0);
        }

        $query = "SELECT COUNT(u.id) quantity 
            FROM `users` u 
            LEFT JOIN timetables t ON u.id = t.user_id AND t.date = '$date' 
            WHERE t.user_id IS NULL
            AND u.id !=" . $userId;
        $result = DB::select($query);
        
        return (isset($result[0]) ? $result[0]->quantity : 0);
    }

    public static function getQuantityOfUsersWithPlan(array $data, array $ratingData)
    {
        /**
         * All users in the group who failed plan today:
         * SELECT COUNT(timetables.id) quantity FROM `timetables` JOIN users ON timetables.user_id=users.id WHERE users.rating BETWEEN 1200 AND 1400 AND timetables.date = '2023-07-15' AND timetables.day_status=-1 GROUP BY day_status;
         *  /*AND timetables.date = '$date'
         */
        $date = Carbon::today()->toDateString();
        $query = "SELECT COUNT(u.id) quantity FROM `users` u
                    JOIN timetables t ON u.id = t.user_id
                        WHERE t.day_status IN (0,1,2,3) AND t.date = '$date';";
        $result = DB::select($query);
        
        return (isset($result[0]) ? $result[0]->quantity : 0);
    }
    
    public static function getQuantityOfUsersFailed(array $data, array $ratingData)
    {
        $date   = Carbon::today()->toDateString();
        $userId = Auth::id();

        if ($ratingData) {

            /**
             * All users in the group who failed plan today:
             * SELECT COUNT(timetables.id) quantity FROM `timetables` JOIN users ON timetables.user_id=users.id WHERE users.rating BETWEEN 1200 AND 1400 AND timetables.date = '2023-07-15' AND timetables.day_status=-1 GROUP BY day_status;
             *  /*AND timetables.date = '$date'
             */
            $query = "SELECT COUNT(timetables.id) quantity_fail FROM `timetables` JOIN users 
                        ON timetables.user_id = users.id WHERE users.rating
                        BETWEEN ".$ratingData['group']->from ." AND ". $ratingData['group']->to ." 
                        AND users.id != $userId
                        AND timetables.date = '$date'
                        AND timetables.day_status=-1 GROUP BY day_status;";
            $result = DB::select($query);
            
            return (isset($result[0]) ? $result[0]->quantity_fail : 0);
        }

        $query = "SELECT COUNT(timetables.id) quantity_fail FROM `timetables` JOIN users 
                    ON timetables.user_id = users.id WHERE timetables.date = '$date'
                    AND users.id != $userId
                    AND timetables.day_status=-1 GROUP BY day_status;";
        $result = DB::select($query);
        
        return (isset($result[0]) ? $result[0]->quantity_fail : 0);
    }

    private static function getStatusOfTheDailyPlanIsValid()
    {
        $date   = Carbon::today()->toDateString();
        $userId = Auth::id();

        $query = "SELECT COUNT(u.id) quantity 
                FROM `users` u 
                LEFT JOIN timetables t ON u.id = t.user_id AND t.date = '$date' 
                WHERE t.user_id = $userId
                AND t.day_status !=-1
                ";
        $result = DB::select($query);
        
        $quantity = $result[0]->quantity;
        return $quantity > 0;
    }
}