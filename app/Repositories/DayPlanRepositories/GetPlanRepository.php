<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 22.08.2021
 * Time: 14:08
 */

namespace App\Repositories\DayPlanRepositories;

use App\Http\Controllers\SubPlanController;
use App\Models\DayPlanModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\DayPlanRepositories\AddNoteToSavedTask;
use App\Models\TimetableModel;

class GetPlanRepository
{
    private $dayPlanModel                 = null;
    private $addNoteToSavedTaskRepository = null;
    private $timetableModel               = null;
    private $subPlan                      = null;

    public function __construct(
        DayPlanModel       $dayPlanModel, 
        AddNoteToSavedTask $addNoteToSavedTask, 
        TimetableModel     $timetableModel,
        SubPlanController  $subPlan,
        )
    {
        $this->dayPlanModel                 = $dayPlanModel;
        $this->addNoteToSavedTaskRepository = $addNoteToSavedTask;
        $this->timetableModel               = $timetableModel;
        $this->subPlan                      = $subPlan;
    }

    public function getLastDayPlan(array $data)
    {
        //сперва получу timetable_id
        $timetableId = $this->getLastTimetableId($data);
        //потом сам план
        $plan = $this->getTasksForLastTimetable($timetableId);
        $plan = $this->addDetailsDataToPlan($plan);
        //die(var_dump($plan));
        //Теперь надо получить статус текущего дня и если он = 3 -> добавить информацию об итоговой оценке и тд
        $planState = $this->getPlanState($timetableId);
        //die(var_dump($planState));
        if(isset($planState[0])){
            if($planState[0]->day_status == 0){
                
                return $planState;
            }
        }

        return $plan;
    }

    public function getDateOfLastTimetable(array $data)
    {
        $dayPlan = DB::table('timetables')->where('date', '=', $data['date'])
            ->where('user_id', '=', $data['id'])
            ->get('date')
            ->toArray();
        if(!$dayPlan){
            return false;
        }

        return true;
    }

    public function getLastTimetableId($data)
    {
        $dayPlan = DB::table('timetables')->where('date', '=', $data['date'])
            ->where('user_id', '=', $data['id'])
            ->get()
            ->toArray();
        if($dayPlan){
            return $dayPlan[0]->id;
        }

        return null;
    }

    private function getTasksForLastTimetable($timetableId)
    {
        $tasks = DB::table('tasks')
                ->join('timetables','tasks.timetable_id', '=', 'timetables.id')
                ->select('tasks.*','timetables.day_status', 'timetables.final_estimation', 'timetables.own_estimation',
                    'timetables.comment') //потом заменить звездочку на конкретные поля
                ->where('timetables.user_id', '=', Auth::id())
                ->where('timetables.id', '=', $timetableId)
                ->orderBy('tasks.type', 'desc')
                ->orderBy('tasks.priority', 'desc')
                ->orderBy('tasks.time', 'desc')
                ->get()
                ->toArray();

        return $tasks;
    }

    /*Получает состояние плана*/
    private function getPlanState($timetableId)
    {
        $timetableInfo = DB::table('timetables')
            ->select('date','day_status', 'time_of_day_plan', 'final_estimation', 'own_estimation', 'comment') //потом заменить звездочку на конкретные поля
            ->where('id', '=', $timetableId)
            ->get()
            ->toArray();

        return $timetableInfo;
    }

    private function addDetailsDataToPlan(array $plan) {
        if (!count($plan)) return $plan;

        foreach($plan as &$task) {
            $detailsData = $this->subPlan->fetchSubPlan($task->id, 'all');
            $task->detailsCompletedPercent = $detailsData['completedPercent'];
            $task->detailsData = $detailsData['data'];
        }
        
        return $plan;
    }
} 