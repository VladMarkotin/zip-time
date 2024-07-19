<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;


use App\Models\User;
use App\Models\TimetableModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Services\PersonalResultServices\traits\GetWorserUsersTrait;

trait GetUserPurposelness
{
    /**
     * Purposelness:
     * Purposelness = Quantity of work days / created plans (all statuses)
     * 
     */
    public static function getData(array $data, array $configs)
    {
        // Log::info(json_encode($configs));
        // die;
        if ($configs['group']) {            
            $usersPurposelnessData = self::getQuantityOfAllDays($configs);
            $usersPurposelnessData = self::getQuantityOfWorkDays($configs, $usersPurposelnessData);
            $usersPurposelnessData = self::getQuantityOfFailedDays($configs, $usersPurposelnessData);
        } else {
            $usersPurposelnessData = self::getQuantityOfAllDays([]);
            $usersPurposelnessData = self::getQuantityOfWorkDays([], $usersPurposelnessData);
            $usersPurposelnessData = self::getQuantityOfFailedDays([], $usersPurposelnessData);
        }
        $usersPurposelnessData = self::getPurposelness($usersPurposelnessData);
        $betterThen            = self::calculatePurposelnessRanking($usersPurposelnessData);
        
        return $betterThen;
    }

    public static function getQuantityOfWorkDays(array $configs, array $usersPurposelnessData)
    {   
        $query = "SELECT t.user_id, COUNT(t.id) workDays FROM `timetables` t
                JOIN users u ON t.user_id = u.id
                WHERE day_status IN(2,3)";

        if ($configs) {
            $query .= " AND u.rating BETWEEN ". $configs['group']->from." AND ".
                    $configs['group']->to;
        }
        $query .= " GROUP BY t.user_id";
        $results = DB::select($query);
        foreach ($results as $result) {
            foreach($usersPurposelnessData as &$userPurposelnessData) {
                if($result->user_id === $userPurposelnessData['user_id']) {
                    $userPurposelnessData['workDays'] = $result->workDays;
                    continue;
                }
            }
        }
        return $usersPurposelnessData;
    }

    public static function getQuantityOfAllDays(array $configs)
    {
        $query = "SELECT t.user_id, COUNT(t.id) allDays FROM `timetables` t
                JOIN users u ON t.user_id = u.id";
        if ($configs) {
            $query .= " WHERE u.rating BETWEEN ". $configs['group']->from." AND ".
                    $configs['group']->to;
        }
        $query .= " GROUP BY t.user_id";
        $results = DB::select($query);

        $usersPurposelnessData = [];
        foreach ($results as $result) {
            $usersPurposelnessData[] = (array) $result;
        }
        return $usersPurposelnessData;
    }

    public static function getQuantityOfFailedDays(array $configs, array $usersPurposelnessData) {
        $query = "SELECT t.user_id, COUNT(t.id) failedDays FROM `timetables` t
                JOIN users u ON t.user_id = u.id
                WHERE day_status = -1";

        if ($configs) {
            $query .= " AND u.rating BETWEEN ". $configs['group']->from." AND ".
                    $configs['group']->to;
        }
        $query .= " GROUP BY t.user_id";

        $results = DB::select($query);
        foreach ($results as $result) {
            foreach($usersPurposelnessData as &$userPurposelnessData) {
                if($result->user_id === $userPurposelnessData['user_id']) {
                    $userPurposelnessData['failedDays'] = $result->failedDays;
                    continue;
                }
            }
        }
        return $usersPurposelnessData;
    }

    private static function getPurposelness(array $usersPurposelnessData)
    {
        // return round( ($allDays) ? ( ($workDays - $failedDays)/ $allDays) * 100 : 0, 2);
        foreach($usersPurposelnessData as &$userPurposelnessData) {
            $allDays = $userPurposelnessData['allDays'];
            $successfulWorkDays = $userPurposelnessData['workDays'] - $userPurposelnessData['failedDays'];
            if ($allDays > 0) {
                $purposelness = ($successfulWorkDays / $allDays) * 100;
            } else {
                $purposelness = 0;
            }
            $userPurposelnessData['purposelness'] = round($purposelness, 2);
        }
        return $usersPurposelnessData;
    }

    private static function calculatePurposelnessRanking(array $usersPurposelnessData)
    {
        $getCurrentUserPurposelness = function(array $usersPurposelnessData) {
            $currentUserId           = Auth::id();

            foreach ($usersPurposelnessData as $userPurposelnessData) {
                if ($userPurposelnessData['user_id'] === $currentUserId) return $userPurposelnessData['purposelness'];
            }
        };

        $currentUserPurposelness = $getCurrentUserPurposelness($usersPurposelnessData);
        $countBetterUsers      = 0;
        $totalUsers            = count($usersPurposelnessData);

        foreach ($usersPurposelnessData as $userPurposelnessData) {
            if ($userPurposelnessData['purposelness'] < $currentUserPurposelness) {
                $countBetterUsers++;
            }
        }
        $percentage = ($countBetterUsers / $totalUsers) * 100;
        return round($percentage, 2);
    }   
}