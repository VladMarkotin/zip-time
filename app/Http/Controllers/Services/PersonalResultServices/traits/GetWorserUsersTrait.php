<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;


use Carbon\Carbon;
use UserGroupTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait GetWorserUsersTrait
{
    //Have to count % who didn`t create plan for today in user`s group
    function getData(array $data, array $ratingData, bool $isRatingLessThanMin)
    {
        // dd($data, $ratingData);
       
        $results = [];
        if ($ratingData['group']) {
            Log::info(json_encode($ratingData));
            $results['QuantityOfUsersFailed'] = self::getQuantityOfUsersFailed($data, $ratingData);
            $results['QuantityOfUsersWithPlan'] = self::getQuantityOfUsersWithPlan($data, $ratingData);
            $results['QuantityOfUsersWithNoPlan'] = self::getQuantityOfUsersWithNoPlan($data, $ratingData);
            $results['QuantityInGroup'] = $data['QuantityInGroup'];
            if ($results['QuantityInGroup']) {
                $persentOfWorserUser = (($results['QuantityOfUsersFailed'] + $results['QuantityOfUsersWithNoPlan'])
                     / $results['QuantityInGroup']) * 100;
                return ($persentOfWorserUser);
            }
        } else {
            $results['QuantityOfUsersFailed'] = self::getQuantityOfUsersFailed($data, []);
            $results['QuantityOfUsersWithPlan'] = self::getQuantityOfUsersWithPlan($data, []);
            $results['QuantityOfUsersWithNoPlan'] = self::getQuantityOfUsersWithNoPlan($data, []);
            $results['QuantityInGroup'] = $data['QuantityInGroup'];
        }
        //Log::info(($results['QuantityOfUsersFailed'] + $results['QuantityOfUsersWithNoPlan'])  ); /// $results['QuantityInGroup']) * 100 
        Log::info( $data['QuantityInGroup']);

        if ($isRatingLessThanMin) {
            return 'n/a';
        }
        
        $persentOfWorserUser = (($results['QuantityOfUsersFailed'] + $results['QuantityOfUsersWithNoPlan'])
                     / $results['QuantityInGroup']) * 100;
                
        return ($persentOfWorserUser);
    }
    
    function getQuantityOfUsersWithNoPlan(array $data, array $ratingData)
    {
        $date = Carbon::today()->toDateString();
        $query = "SELECT COUNT(u.id) quantity 
            FROM `users` u 
            LEFT JOIN timetables t ON u.id = t.user_id AND t.date = '$date' 
            WHERE t.user_id IS NULL";
        $result = DB::select($query);
        
        return (isset($result[0]) ? $result[0]->quantity : 0);
    }

    function getQuantityOfUsersWithPlan(array $data, array $ratingData)
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
    
    function getQuantityOfUsersFailed(array $data, array $ratingData)
    {
        $date = Carbon::today()->toDateString();
        if ($ratingData) {

            /**
             * All users in the group who failed plan today:
             * SELECT COUNT(timetables.id) quantity FROM `timetables` JOIN users ON timetables.user_id=users.id WHERE users.rating BETWEEN 1200 AND 1400 AND timetables.date = '2023-07-15' AND timetables.day_status=-1 GROUP BY day_status;
             *  /*AND timetables.date = '$date'
             */
            $query = "SELECT COUNT(timetables.id) quantity_fail FROM `timetables` JOIN users 
                        ON timetables.user_id = users.id WHERE users.rating
                         BETWEEN ".$ratingData['group']->from ." AND ". $ratingData['group']->to ." 
                          AND timetables.date = '$date'
                          AND timetables.day_status=-1 GROUP BY day_status;";
            $result = DB::select($query);
            
            return (isset($result[0]) ? $result[0]->quantity_fail : 0);
        }

        $query = "SELECT COUNT(timetables.id) quantity_fail FROM `timetables` JOIN users 
                    ON timetables.user_id = users.id WHERE timetables.date = '$date'
                      AND timetables.day_status=-1 GROUP BY day_status;";
        $result = DB::select($query);
        
        return (isset($result[0]) ? $result[0]->quantity_fail : 0);
    }
}