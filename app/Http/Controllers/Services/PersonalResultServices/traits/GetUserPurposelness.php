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
        // if($configs['isTheRatingLessThanMin']) {
        //     return 'n/a';
        // }
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
        $usersPurposelResult   = self::calculatePurposelnessRanking($usersPurposelnessData, $configs);
        
        return $usersPurposelResult;
    }

    public static function getQuantityOfWorkDays(array $configs, array $usersPurposelnessData)
    {   
        $query = "SELECT u.id AS user_id, COALESCE(COUNT(t.id), 0) AS workDays
        FROM users u
        LEFT JOIN timetables t ON u.id = t.user_id AND t.day_status IN (2, 3)";

        if ($configs) {
            $query .= " WHERE u.rating BETWEEN " . $configs['group']->from . " AND " . $configs['group']->to;
        }
        $query .= " GROUP BY u.id";
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
        $query = "SELECT u.id AS user_id, COALESCE(COUNT(t.id), 0) AS allDays 
        FROM users u
        LEFT JOIN timetables t ON u.id = t.user_id";

        if ($configs) {
            $query .= " WHERE u.rating BETWEEN " . $configs['group']->from . " AND " . $configs['group']->to;
        }

        $query .= " GROUP BY u.id";

        $results = DB::select($query);

        $usersPurposelnessData = [];
        foreach ($results as $result) {
            $usersPurposelnessData[] = (array) $result;
        }

        return $usersPurposelnessData;
    }

    public static function getQuantityOfFailedDays(array $configs, array $usersPurposelnessData) {
        $query = "SELECT u.id AS user_id, COALESCE(COUNT(t.id), 0) AS failedDays 
        FROM users u
        LEFT JOIN timetables t ON u.id = t.user_id AND t.day_status = -1";

        if ($configs) {
            $query .= " WHERE u.rating BETWEEN " . $configs['group']->from . " AND " .
            $configs['group']->to;
        }
        $query .= " GROUP BY u.id";

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

    private static function calculatePurposelnessRanking(array $usersPurposelnessData, array $configs)
    {
        $getCurrentUserPurposelness = function($usersPurposelnessData) {
            $currentUserId           = Auth::id();

            foreach ($usersPurposelnessData as $userPurposelnessData) {
                if ($userPurposelnessData['user_id'] === $currentUserId) return $userPurposelnessData['purposelness'];
            }
        };
        
        $getBetterThenPurposelness = function($usersPurposelnessData, $configs, $currentUserPurposelness) {
            if ($configs['isTheRatingLessThanMin']) {
                return 'n/a';
            }
            $countBetterUsers      = 0;
            $totalUsers            = count($usersPurposelnessData) - 1;

            if ($totalUsers === 0) {
                return 0;
            }
            foreach ($usersPurposelnessData as $userPurposelnessData) {
                if ($userPurposelnessData['purposelness'] < $currentUserPurposelness) {
                    $countBetterUsers++;
                }
            }
            $percentage             = ($countBetterUsers / $totalUsers) * 100;
            return round($percentage, 2);
        };

        $currentUserPurposelness = $getCurrentUserPurposelness($usersPurposelnessData);
        $betterThenPurposelness  = $getBetterThenPurposelness($usersPurposelnessData, $configs, $currentUserPurposelness);
        
        return [
            'user_purposelness'        => $currentUserPurposelness, 
            'better_then_Purposelness' => $betterThenPurposelness
        ];
    }   
}