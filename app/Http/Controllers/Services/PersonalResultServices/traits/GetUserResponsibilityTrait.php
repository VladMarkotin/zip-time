<?php
namespace App\Http\Controllers\Services\PersonalResultServices\traits;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait GetUserResponsibilityTrait
{
    public function getData(array $data, array $configs)
    {
        /**
         * Responsibility:
         * (quantity of completed jobs+tasks / quantity of jobs+tasks) * 100
         */
        $allUserTasks = GetUserResponsibilityTrait::getAllUserTasks(Auth::id(), $configs);
        $completedUserTasks = GetUserResponsibilityTrait::completedUserTasks(Auth::id(), $configs);
        
        return ($allUserTasks) ? round( $completedUserTasks / $allUserTasks, 2) * 100 : 0;
    }

    public function getAllUserTasks($id, $configs) //configs on future
    {
        return DB::select('SELECT COUNT(t1.id) all_tasks FROM `tasks` t1 JOIN timetables t2 ON t1.timetable_id = t2.id WHERE t2.user_id = '.$id)[0]
        ->all_tasks;
    }

    public function completedUserTasks($id, $configs) //configs on future
    {
        return DB::select("SELECT COUNT(t1.id) completed_tasks FROM `tasks` t1 JOIN timetables t2 ON t1.timetable_id = t2.id WHERE t2.user_id = $id AND t1.mark >= 50")[0]
        ->completed_tasks;
    }
}