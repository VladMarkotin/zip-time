<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 21.10.2021
 * Time: 14:27
 */

namespace App\Http\Controllers\Services;


class DataTransformationService
{
    public function transformDataForWeekendRequest(array $data)
    {
        $transformJobsToNonRequired  = function ($data){
             //working
            if($data['plan']){
                foreach($data['plan'] as $k => &$val){
                    foreach ($val as $i => &$v){
                        if($i == 'type'){
                            //die(var_dump($val['type']));?? Why $val['type']
                            ($val['type'] == 'required job')  ?: $v = 'non required job';
                            ($val['type'] == 'required task') ?: $v = 'task';
                        }
                    }
                }
            }
            //die(var_dump($data).__FILE__);
            return $data;
        };
        $response = $transformJobsToNonRequired($data);

        return $response;
    }

    public function transformDataForEmergencyRequest(array $data)
    {
        $transformStatus  = function ($data){
            //working
            $dataAsArray = [
                "date"      => $data[0]->date,
                "dayStatus" => $data[0]->day_status,
                "comment"   => $data[0]->comment,
            ];
           //die(var_dump($data).__FILE__);
           return $dataAsArray;
       };
       $response = $transformStatus($data);

       return $response;
    }

    public function transformData(array $data, $way = 1) //1)db->front
    {
        $response = null;
        if($way == 1){
            $response = $this->fromDbToFront($data);
        }else if($way == 2){
            //later from front to db ?
        }

        return ($response) ? $response : $data;
    }

    /*Преобразую здесь строковые значения в плане на день (e.g 'required task') в код, который пишется в базу (e.g 4)*/
    public function getNumValuesOfStrValues($task)
    {
        switch($task['type']){
            case 'required job'    : $task['type'] = 4;
                return $task;
            case 'non required job': $task['type'] = 3;
                return $task;
            case 'required task'   : $task['type'] = 2;
                return $task;
            case 'task'            : $task['type'] = 1;
                return $task;
            case 'reminder'        : $task['type'] = 0;
                return $task;
        }

        return $task;
    }

    private function fromDbToFront(array $data)
    {
        //die(var_dump($data).__FILE__.__LINE__);
        $transformData = [];
        foreach($data as $k => $v){
            $transformData["plan"][$k]["taskId"]   = $v->id;
            $transformData["plan"][$k]["hash"]     = $v->hash_code; //Must be hashCode
            $transformData["plan"][$k]['taskName'] = $v->task_name;
            $transformData["plan"][$k]['time']     = $v->time;
            $transformData["plan"][$k]['type']     = $v->type;
            $transformData["plan"][$k]['priority'] = $v->priority;
            $transformData["plan"][$k]['details']  = htmlspecialchars_decode($v->details);
            $transformData["plan"][$k]['mark']     = ($v->mark != -1) ? $v->mark: "";
            $transformData["plan"][$k]['notes']    = $v->note;
            if( ($v->type == 1) || ($v->type == 2) ){
                $transformData["plan"][$k]['is_ready'] = $v->mark; //Must Be isReady
            }
        }
        //Эту информацию мне нужно добавить в итоговый ответ
        $transformData["dayStatus"]    = $data[0]->day_status;
        $transformData["dayFinalMark"] = $data[0]->final_estimation;
        $transformData["dayOwnMark"]   = $data[0]->own_estimation;
        $transformData["comment"]      = $data[0]->comment;

        /*$transformData["plan"] = $transformData;
        die(var_dump($transformData));*/

        return $transformData;
    }
} 