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
        $this->task = Tasks::where('id', $data['task_id'])->get();
        //Don`t forget about checks
        if ($this->editTaskService->checkTask($data) ) {
            Tasks::where('id',$data['task_id'])->update(['time' => $data['time']]);
            Tasks::where('id',$data['task_id'])->update(['priority' => $data['priority']]);

            return json_encode(['status' => 'success', 'message' => 'Task`s configurations has been changed.'], JSON_UNESCAPED_UNICODE);
        }

        return json_encode(['status' => 'fail', 'message' => 'Error has happend!'], JSON_UNESCAPED_UNICODE);
    }

    public function getSavedNotes(Request $request)
    {
        //get id of saved_task
        $savedTaskId = SavedTask::select('id')->where([['hash_code', $request->get('hash')], ['user_id', Auth::id()]])
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray()[0]['id'];
        //get notes for saved Task
        $notes = SavedNotes::select('note', 'created_at')
        ->where('saved_task_id', $savedTaskId)
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();
        //die(var_dump($notes));
        return json_encode( $notes, JSON_UNESCAPED_UNICODE);
    }
}
