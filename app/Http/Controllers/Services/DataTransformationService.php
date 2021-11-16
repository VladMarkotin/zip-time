<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 21.10.2021
 * Time: 14:27
 */

namespace App\Http\Controllers\Services;


use Illuminate\Support\Facades\Auth;

class DataTransformationService
{
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

    private function fromDbToFront(array $data)
    {
        $transformData = [];
        foreach($data as $k => $v){
            $transformData[$k]["taskId"]   = $v->id;
            $transformData[$k]["userId"]   = Auth::id();
            $transformData[$k]["hash"]     = $v->hash_code;
            $transformData[$k]['taskName'] = $v->task_name;
            $transformData[$k]['time']     = $v->time;
            $transformData[$k]['type']     = $v->type;
            $transformData[$k]['priority'] = $v->priority;
            $transformData[$k]['details']  = $v->details;
            $transformData[$k]['mark']     = ($v->mark != -1) ? $v->mark: "";
            $transformData[$k]['notes']    = $v->note;
            if( ($v->type == 1) ||($v->type == 2) ){
                $transformData[$k]['is_ready'] = $v->mark;
            }
        }

        return $transformData;
    }
} 