<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Services\EditTaskServices\EditTaskService;
use App\Models\Tasks;
use App\Models\SavedNotes;
use App\Models\SavedTask;
use Auth;

class EditController extends Controller
{
    private $editTaskService = null;
    private $task = null;

    public function __construct(EditTaskService $editTaskService)
    {
        $this->editTaskService = $editTaskService;
    }

    public function editCard(Request $request)
    {
        //ok
        $data = $request->all();
        $task_id = $data['task_id'];
        $this->task      = Tasks::find($task_id);
        $current_task_type = $this->task->type;
        $new_type         = $data['type'];
        //Don`t forget about checks
        if ($this->editTaskService->checkTask($data) ) {
            
            $updated_data = [
                'time'     => $data['time'],
                'priority' => $data['priority']
            ];

            if ($new_type !== $current_task_type) {
                $updated_data = $this->editType($new_type, $current_task_type, $task_id, $updated_data);
            }
            dd($updated_data);

            Tasks::where('id', $task_id)->update($updated_data);
            return json_encode(['status' => 'success', 'message' => 'Task`s configurations has been changed.'], JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['status' => 'fail', 'message' => 'Error has happend!'], JSON_UNESCAPED_UNICODE);
    }

    private function editType($new_type, $current_task_type,$task_id, $updated_data) {
        if ($current_task_type === 4) {
            $this->editTaskService->checkReqJobsInDayPlan($task_id);
        } 
        $updated_data['type'] = $new_type;

        return $updated_data;
    }
}
