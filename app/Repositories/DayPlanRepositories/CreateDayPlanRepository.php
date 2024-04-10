<?php

namespace App\Repositories\DayPlanRepositories;

use Carbon\Carbon;
use App\Models\Tasks;
use App\Models\SavedNotes;
use App\Models\DayPlanModel;
use App\Events\DailyReminder;
use App\Models\TimetableModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SavedTask2Repository;
use App\Http\Controllers\Services\NotesService;
use App\Http\Controllers\Services\AddPlanService;
use App\Repositories\DayPlanRepositories\AddNoteToSavedTask;

class CreateDayPlanRepository
{
    private $model;
    private $tasks;
    private $planService;
    private $savedTask2Repository;
    private $savedNotes;
    private $addNoteToSavedTask;

    public function __construct(
        DayPlanModel $dayPlanModel,
        Tasks $tasks,
        AddPlanService $planService,
        SavedTask2Repository $savedTask2Repository,
        NotesService $savedNotes,
        AddNoteToSavedTask $addNoteToSavedTask
    ) {
        $this->model                = $dayPlanModel;
        $this->tasks                = $tasks;
        $this->planService          = $planService;
        $this->savedNotes           = $savedNotes;
        $this->savedTask2Repository = $savedTask2Repository;
        $this->addNoteToSavedTask  = $addNoteToSavedTask;
    }

    public function createDayPlan(array $data)
    {
        $dataForDayPlanCreation["user_id"]          = Auth::id();
        $dataForDayPlanCreation["date"]             = Carbon::now()->format('Y-m-d');; //Carbon::today();
        $dataForDayPlanCreation["day_status"]       = $data["day_status"]; //$this->getNumValuesOfStrValues($data["day_status"]);//temporary variant. day_status has to be general!!! Now it would not working
        $dataForDayPlanCreation["final_estimation"] = 0;
        $dataForDayPlanCreation["own_estimation"]   = 0;
        $dataForTasks = [];
        try {
            DB::transaction(function () use ($dataForDayPlanCreation, $data) {
                //Save ifo about timetable
                $this->model->fill($dataForDayPlanCreation);
                $this->model->save();
                /*test*/
                //die(var_dump($data));
                foreach ($data as $i => $val) {
                    if (is_array($val)) {
                        foreach ($val as $index => $v) {
                            if (is_array($v)) {
                                $k = 0; //Counter for excluding copies
                                foreach ($v as $v2) {
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
                                }
                            }
                        }
                    }
                }
                //Save info about tasks              
                Tasks::insert($dataForTasks);
            });
            /*end test*/
        } catch (\Exception $e) {
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
        switch ($data) {
            case 'Work Day':
                return 2;
            case 'Weekend':
                return 1;
            case 'Holiday':
                return 4;
            case 'Emergency':
                return 0;
        }

        return 0;
    }

    private function getNumValueOfTaskTypes($task)
    {
        switch ($task['type']) {
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

        return $task['type'];
    }

    private function getLastTimetableId()
    {
        $timetable = DB::table('timetables')
            ->select(DB::raw('id'))
            ->max('id');

        return $timetable;
    }


    // public function reminder()
    // {

    // echo 'domn';




    //         $now = Carbon::now();
    //         $time = \Carbon\Carbon::now()->setTimeFromTimeString('5:00 PM');

    //         $day_plan = TimetableModel::where('date', Carbon::today())
    //             ->where('user_id', 1)
    //             ->get('day_status')
    //             ->toArray();
    //         $dayStatus = implode("", array_column($day_plan, 'day_status'));

    //         switch ($dayStatus) {
    //             case null:
    //                 if ($now < $time) {
    //                      //DailyReminder::dispatch( 1, $this->reminderMessages()[0]);
    //                     event(new DailyReminder(1, $this->reminderMessages()[0]));
    //                 }
    //                 break;
    //                 // case 1:
    //             case 2:
    //                 if ($now > $time) {

    //                     //  DailyReminder::dispatch(1, $this->reminderMessages()[1]);
    //                     event(new DailyReminder(1, $this->reminderMessages()[1]));
    //                 }
    //                 break;

    //     }
    // }





    // private function reminderMessages()
    // {
    //     return [
    //         'Please remember to create a plan for today.',
    //         'Please remember to complete today\'s plan',
    //     ];
    // }


    public function reminder(): void
    {
        $now = Carbon::now();
        $time = \Carbon\Carbon::now()->setTimeFromTimeString('10:00 AM');
        switch ($now) {
            case $now < $time:
                collect($this->users_with_no_day_Plan())->map(function ($e) {
                    event(new  DailyReminder($e, $this->reminderMessages()[0]));
                });
                break;
            case $now > $time:
                collect($this->users_with_unfinished_day_Plan())->map(function ($e) {
                    event(new  DailyReminder($e, $this->reminderMessages()[1]));
                });
                break;
        }
    }


    private function reminderMessages()
    {
        return [
            'Please remember to create a plan for today :)',
            'Please remember to complete all tasks created today :)',
        ];
    }

    private function users_with_no_day_Plan()
    {
        $today = Carbon::today()->toDateString();
        $query =
            "SELECT users.id FROM users WHERE
                        users.id NOT IN (select b.user_id
                            from timetables b
                               where b.date = '" .
            $today .
            "');
                        ";
        //dd($query);
        $idsArr = DB::select($query);
        $ids = [];
        foreach ($idsArr as $v) {
            $ids[] = $v->id;
        }
        return $ids;
    }

    private function users_with_unfinished_day_Plan()
    {
        
        $query ="SELECT users.id  FROM users JOIN timetables ON users.id = timetables.user_id 
                                     WHERE timetables.day_status = 2 ";
        $idsArr = DB::select($query);
        $ids = [];
        foreach ($idsArr as $v) {
            $ids[] = $v->id;
        }
        return $ids;
    }
}
