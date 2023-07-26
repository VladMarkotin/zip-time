<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;


use App\Models\User;
use App\Models\TimetableModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait GetUserPurposelness
{
    /**
     * Purposelness:
     * Purposelness = Quantity of work days / created plans (all statuses)
     * 
     */
    public function getData(array $data, array $configs)
    {
        $allDays = GetUserPurposelness::quantityOfAllDays($data, $configs);
        $workDays = GetUserPurposelness::quantityOfWorkDays($data, $configs);
        
        return round( ($allDays) ? ($workDays / $allDays) * 100 : 0, 2);
    }

    public function quantityOfWorkDays(array $data, array $configs)
    {
        return DB::select("SELECT COUNT(t.id) plans FROM `timetables` t JOIN users u ON t.user_id = u.id WHERE u.rating BETWEEN ".$configs['group']->from." AND ".$configs['group']->to
        ." AND day_status IN(2,3)")[0]->plans;
    }

    public function quantityOfAllDays(array $data, array $configs)
    {
        return DB::select("SELECT COUNT(t.id) plans FROM `timetables` t JOIN users u ON t.user_id = u.id  WHERE u.rating BETWEEN ". $configs['group']->from." AND ".
             $configs['group']->to ." AND t.user_id = ".Auth::id() )[0]->plans;
    }
}