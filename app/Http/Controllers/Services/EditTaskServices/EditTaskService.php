<?php
namespace App\Http\Controllers\Services\EditTaskServices;


use App\Models\DefaultConfigs;
use Auth;
use App\Repositories\EstimationRepository;
use App\Models\Tasks;
use Carbon;

class EditTaskService
{
    private $defaultConfigs = null;
    private $estimationRepository = null;

    public function __construct(EstimationRepository $estimationRepository)
    {
        $this->estimationRepository = $estimationRepository;
    }

    public function checkTask(array $data)
    {
        $checks = [];
        $this->defaultConfigs = DefaultConfigs::where('config_block_id', 2)->get()->toArray();
        $checks[] = $this->checkDayPlanTime($data);
        foreach ($checks as $c) {
            if (!$c) {
                return false;
            }
        }

        return true;
    }

    public function checkDayPlanTime(array $data)
    {
        $configs = json_decode($this->defaultConfigs[0]['config_data']) ;
        if ($data['time'] < $configs->cardRules[0]->maxTime) {
            //get timetableId
            //var_dump($data['task_id']);
            $timetableId = Tasks::select('timetable_id')->where('id', $data['task_id'])->get()->toArray()[0]['timetable_id'];
            //get all tasks from plan and sum time
            $timeOnPlan = $this->estimationRepository->sumTime($timetableId);
            //sum timeonplan and changed time
            //...
            //check
            //die(var_dump($this->defaultConfigs[0]['config_data']));
            return true;
        }
    } 

    public function checkReqJobsInDayPlan($task_id) {
        $timetable_id = Tasks::where('id', $task_id)->value('timetable_id');

        return Tasks::where('timetable_id', $timetable_id)->where('type', 4)->where('id', '!=', $task_id)->count() >= 2;
    }
}