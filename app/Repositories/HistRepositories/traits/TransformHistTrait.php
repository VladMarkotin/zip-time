<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 05.01.2022
 * Time: 8:58
 */
namespace App\Repositories\HistRepositories\traits;

use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;

trait TransformHistTrait
{
    // function transformData(array $data, array $period)
    // {

    //    // dd($data);
    //     $finalArray = [
    //         "userId" => Auth::id(),
    //         "plans" => [],
    //     ];
    //     if(isset($period['date'])){
    //         $finalArray["date"] = $period['date'];
    //     }else {
    //         $finalArray["from"] = $period['from'];
    //         $finalArray["to"] = $period['to'];
    //     }
    //     /*
    //      * I have to get this structure:
    //      * [
    //      *     [
    //      *      "userId"            =>
    //      *      "from"              =>
    //      *      "to"                =>
    //      *      "plans"             => [
    //      *                                "<date>" => [
    //              *                                      "timetable_id"     =>
    //              *                                      "day_status"       =>
    //              *                                      "final_estimation" =>
    //              *                                      "own_estimation"   =>
    //              *                                      "comment"          =>
    //              *                                      "tasks" => [
    //              *                                        [
    //              *                                            "id"               =>
    //                  *                                        "task_name"        =>
    //                  *                                        "hash_code"        =>
    //                  *                                        "type"             =>
    //                  *                                        "priority"         =>
    //                  *                                        "details"          =>
    //                  *                                        "time"             =>
    //                  *                                        "mark"             =>
    //                  *                                        "note"             =>
    //                  *                                        "created_at"       =>
    //                  *                                        "updated_at"       =>
    //          *                                             ],
    //          *                                             [
    //                  *                                        "id"               =>
    //          *                                                "task_name"        =>
    //                  *                                        "hash_code"        =>
    //                  *                                        "type"             =>
    //                  *                                        "priority"         =>
    //                  *                                        "details"          =>
    //                  *                                        "time"             =>
    //                  *                                        "mark"             =>
    //                  *                                        "note"             =>
    //                  *                                        "created_at"       =>
    //                  *                                        "updated_at"       =>
    //      *                                                ],
    //      *                                              ],
    //      *                                             ],
    //      *     ]
    //     */
    //     $finalArray = self::createPlanArray($data,  $finalArray);
    //     //$finalArray = self::setDaytasks($data);

    //     return $finalArray;
    // }

    // function createPlanArray(array $data, array $finalArray)
    // {

    //     $i = 0;
    //     //
    //     foreach($data as $k => $v){
    //         $finalArray["plans"][$v->date]['dayStatus']                   = $v->dayStatus;
    //         $finalArray["plans"][$v->date]['dayFinalMark']                  = $v->dayFinalMark;
    //         $finalArray["plans"][$v->date]['dayOwnMark']                    = $v->dayOwnMark;
    //         $finalArray["plans"][$v->date]['comment']                       = $v->comment;
    //         $finalArray["plans"][$v->date]['tasks'] = [];

    //         // $dayTask = Tasks::where('timetable_id', $v->timetableId)
    //         // ->where('')
    //         // ->get()
    //         // ->toArray();
    //         // foreach ($dayTask as &$arr)
    //         // {
    //         //     $arr['hashCode'] = $arr['hash_code'];
    //         //     $arr['taskName'] = $arr['task_name'];
    //         //     unset($arr['task_name']);
    //         //     unset($arr['hash_code']);
    //         // }
    //         // $finalArray["plans"][$v->date]['tasks'] = $dayTask;

    //             /*  for($j = 0; $j < 9; $j++){
    //                     $finalArray["plans"][$v->date]['tasks'][$j]['taskId']           = $v->taskId;//?
    //                     $finalArray["plans"][$v->date]['tasks'][$j]["hashCode"]         = $v->hashCode;
    //                     $finalArray["plans"][$v->date]['tasks'][$j]["taskName"]         = $v->taskName;
    //                     $finalArray["plans"][$v->date]['tasks'][$j]["type"]             = $v->type;
    //                     $finalArray["plans"][$v->date]['tasks'][$j]["priority"]         = $v->priority;
    //                     $finalArray["plans"][$v->date]['tasks'][$j]["details"]          = $v->details;
    //                     $finalArray["plans"][$v->date]['tasks'][$j]["time"]             = $v->time;
    //                     $finalArray["plans"][$v->date]['tasks'][$j]["mark"]             = $v->mark;
    //                     $finalArray["plans"][$v->date]['tasks'][$j]["notes"]            = $v->notes;
    //                 }*/
    //                 $i++;
    //             }

    //     //  foreach($data as $k => $v){
    //     //     $j = 0;
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]['taskId']           = $v->taskId;//?
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]["hashCode"]         = $v->hashCode;
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]["taskName"]         = $v->taskName;
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]["type"]             = $v->type;
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]["priority"]         = $v->priority;
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]["details"]          = $v->details;
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]["time"]             = $v->time;
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]["mark"]             = $v->mark;
    //     //     $finalArray["plans"][$v->date]['tasks'][$j]["notes"]            = $v->notes;
    //     //   $j++;

    //     //  }
    //  // dd(  $finalArray);
    //   return $finalArray;
    // }



    function transformData(array $data, array $period)
    {
        // dd($data);
        $finalArray = [
            'userId' => Auth::id(),
            'plans' => [],
        ];
        if (isset($period['date'])) {
            $finalArray['date'] = $period['date'];
        } else {
            $finalArray['from'] = $period['from'];
            $finalArray['to'] = $period['to'];
        }
        foreach ($data as $v) {
            $finalArray['plans'][$v->date]['dayStatus'] = $v->dayStatus;
            $finalArray['plans'][$v->date]['dayFinalMark'] = $v->dayFinalMark;
            $finalArray['plans'][$v->date]['dayOwnMark'] = $v->dayOwnMark;
            $finalArray['plans'][$v->date]['comment'] = $v->comment;

            $finalArray['plans'][$v->date]['tasks'] = self::getTasksforDay(
                $data,
                $v->date
            );
        }
        return $finalArray;
    }

    private function getTasksforDay(array $data, $date)
    {
        $tasks = [];
        foreach ($data as $task) {
            if ($task->date == $date) {
                array_push($tasks, $task);
            }
        }
        return $tasks;
    }
}
