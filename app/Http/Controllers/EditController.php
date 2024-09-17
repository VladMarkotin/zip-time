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
    private $task            = null;
    private $response        = ['status' => '', 'message' => '', 'updated_data' => []];

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

        $updated_data = [];

        //Don`t forget about checks
        if ($this->editTaskService->checkTask($data) ) {
            
            $updated_data = [
                'time'     => $data['time'],
                'priority' => $data['priority']
            ];
            $updated_data['time']     = $data['time'];
            $updated_data['priority'] = $data['priority'];

            $this->setResponse([
                'status'       => 'success',
                'message'      => 'Task`s configurations has been changed.',
                'updated_data' => $updated_data,

            ]);
        } else {
            $this->setResponse([
                'status'       => 'error',
                'message'      => 'Error has happend!',
                'updated_data' => $updated_data,

            ]);
        }

        if ($new_type !== $current_task_type) {
            $updated_data = $this->editType($new_type, $current_task_type, $task_id, $updated_data);
        }

        if (count($updated_data)) {
            Tasks::where('id', $task_id)->update($updated_data);
        }

        return json_encode($this->getResponse(), JSON_UNESCAPED_UNICODE);
    }

    private function editType($new_type, $current_task_type,$task_id, $updated_data) {
        if ($current_task_type === 4) {
            $checkReqJobs = $this->editTaskService->checkReqJobsInDayPlan($task_id);
            
            if (!$checkReqJobs) {
                $this->setResponse([
                    'status'       => 'error',
                    'message'      => 'The plan for the day must include at least two required jobs.!',
                    'updated_data' => $updated_data,
    
                ]);
                return $updated_data;
            }
        } 
        $updated_data['type'] = $new_type;
        $updated_data['mark'] = -1;
        $this->setResponse([
            'updated_data' => $updated_data,
        ]);

        return $updated_data;
    }

    // private function setResponse($status, $message, $updated_data) {
    //     $this->response['status']       = $status;
    //     $this->response['message']      = $message;
    //     $this->response['updated_data'] = $updated_data;
    // }

    private function setResponse(array $data) {
        $keys = ['status', 'message', 'updated_data'];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $keys) && $value !== '') {
                $this->response[$key] = $value;
            }
        }
    }

    private function getResponse() {
        return $this->response;
    }
}
