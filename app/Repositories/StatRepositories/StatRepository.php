<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 26.11.2021
 * Time: 15:45
 */
namespace App\Repositories\StatRepositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatRepository
{
    public function getStat(array $data)
    {
        $response = [];
        switch(isset($data['date']) ){
            case true:
                $response = $this->getStatForPeriod($data['date']);
                break;
            case false:
                $response = $this->getStatForPeriod($data);
                break;
        }

        return $response;
    }

    private function getStatForPeriod($period)
    {
        if(is_array($period)){
            $getReadyQuery = function ($period){
                return $query = "SELECT * FROM `tasks` JOIN `timetables` ON `tasks`.`timetable_id` = `timetables`.`id`
                                    WHERE timetables.date BETWEEN '$period[from]'
                                     AND '$period[to]'
                                     AND timetables.user_id = 1";
            };
        }else{
            $getReadyQuery = function ($period){
                $query = "SELECT * FROM tasks JOIN timetables ON tasks.timetable_id = timetables.id WHERE
                            timetables.date = '". $period ."'"." AND timetables.user_id = ".Auth::id();

                return $query;
            };
        }
        $query    = $getReadyQuery($period);
        $response = DB::select($query);

        return $response;
    }
} 