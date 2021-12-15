<?php

namespace App\Repositories\DayPlanRepositories;

use App\Http\Controllers\Services\AddPlanService;
use App\Http\Controllers\Services\NotesService;
use App\Models\SavedNotes;
use App\Repositories\SavedTask2Repository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\DayPlanModel;
use App\Models\Tasks;
use App\Repositories\DayPlanRepositories\AddNoteToSavedTask;
use Illuminate\Support\Facades\Log;

class CreateDayPlanRepository
{
    private $model;
    private $tasks;
    private $planService;
    private $savedTask2Repository;
    private $savedNotes;
    private $addNoteToSavedTask;

    public function __construct(DayPlanModel $dayPlanModel,
                                Tasks $tasks,
                                AddPlanService $planService,
                                SavedTask2Repository $savedTask2Repository,
                                NotesService $savedNotes,
                                AddNoteToSavedTask $addNoteToSavedTask
                                )
    {
        $this->model                = $dayPlanModel;
        $this->tasks                = $tasks;
        $this->planService          = $planService;
        $this->savedNotes           = $savedNotes;
        $this->savedTask2Repository = $savedTask2Repository;
        $this->addNoteToSavedTask  = $addNoteToSavedTask;
    }

    public function createDayPlan(array $data)
    {
        //die(var_dump($data).__FILE__);
        $dataForDayPlanCreation["user_id"]          = Auth::id();
        $dataForDayPlanCreation["date"]             = Carbon::today();
        $dataForDayPlanCreation["day_status"]       = $this->getNumValuesOfStrValues($data["day_status"]);//temporary variant. day_status has to be general!!! Now it would not working
        $dataForDayPlanCreation["final_estimation"] = 0;
        $dataForDayPlanCreation["own_estimation"]   = 0;
        //die(var_dump($dataForDayPlanCreation));
        $dataForTasks = [];
        try{
            DB::transaction(function () use ($dataForDayPlanCreation, $data) {
                //Save ifo about timetable
                $this->model->fill($dataForDayPlanCreation);
                $this->model->save();
                /*test*/
                //die(var_dump($data));
                foreach($data as $i => $val) {
                    if (is_array($val)) {
                        foreach ($val as $index => $v) {
                            if (is_array($v)) {
                                $k = 0;//Counter for excluding copies
//                                die(var_dump($v));
                                foreach($v as $v2){
                                    $dataForTasks[$index]['timetable_id'] = $this->getLastTimetableId();
                                    $dataForTasks[$index]['hash_code']    = $v['hash'];
                                    $dataForTasks[$index]['task_name']    = $v['taskName'];
                                    $dataForTasks[$index]['type']         = $this->getNumValueOfTaskTypes($v);
                                    $dataForTasks[$index]['priority']     = $v['priority'];
                                    $dataForTasks[$index]['details']      = $v['details'];
                                    $dataForTasks[$index]['time']         = $v['time'];
                                    $dataForTasks[$index]['mark']         = -1;
                                    $dataForTasks[$index]['note']         = $v['notes'];
                                    $dataForTasks[$index]['created_at']   = DB::raw('CURRENT_TIMESTAMP(0)');
                                    $dataForTasks[$index]['updated_at']   = DB::raw('CURRENT_TIMESTAMP(0)');
                                    /* !!! Add note in notes if hash_code and note are existing*/
                                    //Но сначала мне надо получить saved_task_id
                                    if( ($dataForTasks[$index]['hash_code']) && ($dataForTasks[$index]['note'] && (!$k)) ){
                                        $params = [
                                            "hash_code"     => $dataForTasks[$index]['hash_code'],
                                            "user_id"       => Auth::id(),
                                            "note"          => $dataForTasks[$index]['note']
                                        ];
                                        $response = $this->savedNotes->addNoteForSavedTask($params);
                                        //work but with copies!;
                                        if($response){
                                            $this->addNoteToSavedTask->addSavedNote($params);
                                            $k++;
                                        }
                                    }
                                }

                            }
                        }
                    }
                }
                //Save info about tasks
                Tasks::insert($dataForTasks);
            });
            /*end test*/
        } catch(\Exception $e){
            Log::error($e->getMessage());
        }

        return response()->json([
            'status' => 'success.',
            'message' => 'Plan has been successfully created. We wish you to realize conceived :) '
        ]);
    }

    private function getNumValuesOfStrValues($data)
    {
        //die(var_dump($data).__FILE__."\nLine: ".__LINE__);
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

    private function getSavedTaskId(array $params)
    {}
}

