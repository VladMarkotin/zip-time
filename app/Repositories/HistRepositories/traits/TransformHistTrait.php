<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 05.01.2022
 * Time: 8:58
 */
namespace App\Repositories\HistRepositories\traits;

use Illuminate\Support\Facades\Auth;

trait TransformHistTrait
{
    function transformData(array $data, array $period)
    {
        $finalArray = [
            "userId" => Auth::id(),
            "plans" => [],
        ];
        if(isset($period['date'])){
            $finalArray["date"] = $period['date'];
        }else {
            $finalArray["from"] = $period['from'];
            $finalArray["to"] = $period['to'];
        }
        /*
         * I have to get this structure:
         * [
         *     [
         *      "userId"            =>
         *      "from"              =>
         *      "to"                =>
         *      "plans"             => [
         *                                "<date>" => [
                 *                                      "timetable_id"     =>
                 *                                      "day_status"       =>
                 *                                      "final_estimation" =>
                 *                                      "own_estimation"   =>
                 *                                      "comment"          =>
                 *                                      "tasks" => [
                 *                                        [
                 *                                            "id"               =>
                     *                                        "task_name"        =>
                     *                                        "hash_code"        =>
                     *                                        "type"             =>
                     *                                        "priority"         =>
                     *                                        "details"          =>
                     *                                        "time"             =>
                     *                                        "mark"             =>
                     *                                        "note"             =>
                     *                                        "created_at"       =>
                     *                                        "updated_at"       =>
             *                                             ],
             *                                             [
                     *                                        "id"               =>
             *                                                "task_name"        =>
                     *                                        "hash_code"        =>
                     *                                        "type"             =>
                     *                                        "priority"         =>
                     *                                        "details"          =>
                     *                                        "time"             =>
                     *                                        "mark"             =>
                     *                                        "note"             =>
                     *                                        "created_at"       =>
                     *                                        "updated_at"       =>
         *                                                ],
         *                                              ],
         *                                             ],
         *     ]
        */
        $finalArray = self::createPlanArray($data, $finalArray);

        return $finalArray;
    }

    function createPlanArray(array $data, array $finalArray)
    {
        $i = 0;
        foreach($data as $k => $v){
            $finalArray["plans"][$v->date]['timetableId']                   = $v->id;
            $finalArray["plans"][$v->date]['dayStatus']                     = $v->day_status;
            $finalArray["plans"][$v->date]['finalEstimation']               = $v->final_estimation;
            $finalArray["plans"][$v->date]['ownEstimation']                 = $v->own_estimation;
            $finalArray["plans"][$v->date]['comment']                       = $v->comment;
            $finalArray["plans"][$v->date]['tasks'][$i]["hashCode"]         = $v->hash_code;
            $finalArray["plans"][$v->date]['tasks'][$i]["taskName"]         = $v->task_name;
            $finalArray["plans"][$v->date]['tasks'][$i]["type"]             = $v->type;
            $finalArray["plans"][$v->date]['tasks'][$i]["priority"]         = $v->priority;
            $finalArray["plans"][$v->date]['tasks'][$i]["details"]          = $v->details;
            $finalArray["plans"][$v->date]['tasks'][$i]["time"]             = $v->time;
            $finalArray["plans"][$v->date]['tasks'][$i]["mark"]             = $v->mark;
            $finalArray["plans"][$v->date]['tasks'][$i]["note"]             = $v->note;
            $i++;
        }

        return $finalArray;
    }
} 