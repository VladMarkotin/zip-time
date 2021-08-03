<?php

namespace App\Repositories\DayPlanRepositories;

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
        //die(var_dump($data));
        $dataForDayPlanCreation["user_id"]          = Auth::id();
        $dataForDayPlanCreation["date"]             = Carbon::today();
        $dataForDayPlanCreation["day_status"]       = $this->getNumValuesOfStrValues($data["day_status"]);//temporary variant. day_status has to be general!!! Now it would not working
        $dataForDayPlanCreation["final_estimation"] = 0;
        $dataForDayPlanCreation["own_estimation"]   = 0;

        $dataForTasks = [];
        //die(var_dump($data));
        foreach($data as $i => $val) {
            if (is_array($val)) {

                foreach ($val as $v) {
                    if (is_array($v)) {
                        foreach($v as $v2){
                            //die(var_dump($v));
                            $dataForTasks[$i]['hash_code'] = $v['hash'];
                            $dataForTasks[$i]['task_name'] = $v['taskName'];
                            $dataForTasks[$i]['type'] = $this->getNumValueOfTaskTypes($v);
                            $dataForTasks[$i]['priority'] = $v['priority'];
                            $dataForTasks[$i]['details'] = $v['details'];
                            $dataForTasks[$i]['time'] = $v['time'];
                            $dataForTasks[$i]['mark'] = -1;
                            $dataForTasks[$i]['note'] = $v['notes'];
                        }

                    }
               }
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
        //die(var_dump($task));
        switch($task['type']){
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

