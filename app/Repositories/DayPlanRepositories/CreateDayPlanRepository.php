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
        $dataForDayPlanCreation["user_id"]          = Auth::id();
        $dataForDayPlanCreation["date"]             = Carbon::today();
        $dataForDayPlanCreation["day_status"]       = $this->getNumValuesOfStrValues($data["day_status"]);//temporary variant. day_status has to be general!!! Now it would not working
        $dataForDayPlanCreation["final_estimation"] = 0;
        $dataForDayPlanCreation["own_estimation"]   = 0;

        $dataForTasks = [];
        try{
            //Save ifo about timetable
            $this->model->fill($dataForDayPlanCreation);
            $this->model->save();
            /*test*/
            foreach($data as $i => $val) {
                if (is_array($val)) {

                    foreach ($val as $index => $v) {
                        if (is_array($v)) {
                            foreach($v as $v2){
                                //die(var_dump($v));
                                $dataForTasks[$index]['timetable_id'] = $this->getLastTimetableId();
                                $dataForTasks[$index]['hash_code'] = $v['hash'];
                                $dataForTasks[$index]['task_name'] = $v['taskName'];
                                $dataForTasks[$index]['type'] = $this->getNumValueOfTaskTypes($v);
                                $dataForTasks[$index]['priority'] = $v['priority'];
                                $dataForTasks[$index]['details'] = $v['details'];
                                $dataForTasks[$index]['time'] = $v['time'];
                                $dataForTasks[$index]['mark'] = -1;
                                $dataForTasks[$index]['note'] = $v['notes'];
                            }

                        }
                    }
                }
            }
            /*end test*/

            //Save info about tasks
            Tasks::insert($dataForTasks);

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

    private function getLastTimetableId()
    {
        $timetable = DB::table('timetables')
            ->select(DB::raw('id'))
            ->max('id');

        return $timetable;
    }
}

