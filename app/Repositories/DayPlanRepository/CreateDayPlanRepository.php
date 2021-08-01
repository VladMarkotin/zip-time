<?php

namespace App\Repositories\DayPlanRepository;

use App\Http\Controllers\Services\AddPlanService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\DayPlanModel;
use App\Models\Tasks;
use Mockery\CountValidator\Exception;

class CreateDayPlanRepository
{
    private $model;
    private $tasks;
    private $planService;

    public function __construct(DayPlanModel $dayPlanModel,
                                Tasks $tasks,
                                AddPlanService $planService
                                )
    {
        $this->model       = $dayPlanModel;
        $this->tasks       = $tasks;
        $this->planService = $planService;
    }

    public function createDayPlan(array $data)
    {
        $dataForDayPlanCreation["user_id"]          = Auth::id();
        $dataForDayPlanCreation["date"]             = Carbon::today();
        $dataForDayPlanCreation["day_status"]       = $this->getNumValuesOfStrValues($data[0]["value"]);//temporary variant. day_status has to be general!!! Now it would not working
        $dataForDayPlanCreation["final_estimation"] = 0;
        $dataForDayPlanCreation["own_estimation"]   = 0;

        $dataForTasks = [];
        foreach($data as $i => $val){
            foreach($val as $v){
                $dataForTasks[$i]['hash_code'] = $val['hash'];
                $dataForTasks[$i]['task_name'] = $val['inputValue'];
                $dataForTasks[$i]['type'] = $this->getNumValueOfTaskTypes($val);
                $dataForTasks[$i]['priority'] = $val['defaultPriority'];
                $dataForTasks[$i]['details'] = $val['details'];
                $dataForTasks[$i]['time'] = $val['time'];
                $dataForTasks[$i]['mark'] = -1;
                $dataForTasks[$i]['note'] = $val['notes'];
            }
        }
        //die(var_dump($dataForTasks)); //$data с нужными мне параметрами
        try{
            $this->model->fill($dataForDayPlanCreation);
            $this->model->save();
            //$this->tasks->fill()
        } catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Plan for this day has been already created!'
            ]);//
        }


    }

    private function getNumValuesOfStrValues($data)
    {
        switch($data){
            case 'Work Day'  : return 2;
            case 'Weekend'   : return 1;
            case 'Holiday'   : return 4;
            case 'Emergency' : return 0;
        }

        return 0;
    }

    private function getNumValueOfTaskTypes($task)
    {
        switch($task['defaultTaskType']){
            case 'required job':
                return 4;
            case 'non required job':
                return 3;
            case 'required task':
                return 2;
            case 'task':
                return 1;
            case 'reminder':
                return 0;
        }

        return 4;
    }
}
