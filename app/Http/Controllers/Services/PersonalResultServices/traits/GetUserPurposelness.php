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
            $allDays = GetUserPurposelness::quantityOfAllDays($data, $configs);
            $workDays = GetUserPurposelness::quantityOfWorkDays($data, $configs);
            $failedDays = GetWorserUsersTrait::getQuantityOfUsersFailed($data, $configs);
        } else {
            $allDays = GetUserPurposelness::quantityOfAllDays($data, []);
            $workDays = GetUserPurposelness::quantityOfWorkDays($data, []);
            $failedDays = GetWorserUsersTrait::getQuantityOfUsersFailed($data, []);
        }
        
        return round( ($allDays) ? ( ($workDays - $failedDays)/ $allDays) * 100 : 0, 2);
    }

    public static function quantityOfWorkDays(array $data, array $configs)
    {
        if ($configs) {
            return DB::select("SELECT COUNT(t.id) plans FROM `timetables` t JOIN users u ON t.user_id = u.id WHERE u.rating BETWEEN ".$configs['group']->from." AND ".$configs['group']->to
            ." AND day_status IN(2,3)")[0]->plans;
        }

        return DB::select("SELECT COUNT(t.id) plans FROM `timetables` t JOIN users u ON t.user_id = u.id WHERE  day_status IN(2,3)")[0]->plans;
    }

    public static function quantityOfAllDays(array $data, array $configs)
    {
        // Log::info(json_encode($configs));
        // die;
        if ($configs) {
            return DB::select("SELECT COUNT(t.id) plans FROM `timetables` t JOIN users u ON t.user_id = u.id  WHERE u.rating BETWEEN ". $configs['group']->from." AND ".
                 $configs['group']->to ." AND t.user_id = ".Auth::id() )[0]->plans;
        }

        return ( DB::select("SELECT COUNT(t.id) plans FROM `timetables` t JOIN users u ON t.user_id = u.id" )[0]->plans); //WHERE u.rating BETWEEN ". $configs['group']->from." AND ". $configs['group']->to ." AND t.user_id = ".Auth::id()
    }
}