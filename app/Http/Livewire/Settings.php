<?php
namespace App\Http\Livewire;

use Auth;

use Livewire\Component;
use App\Models\SavedTask;
use App\Models\SavedNotes;
use Livewire\WithPagination;
use App\Http\Livewire\LWServices\TaskStatService as TSS;
use App\Http\Livewire\LWServices\SavedNoteService as SNS;

class Settings extends Component
{
    use WithPagination;

    private $savedTasks = [];
    public $info = [];
    public $notes = [];
    public $sT = null;
    public $taskName, $type, $priority, $time, $taskId; //for updates

    public function render(SavedTask $savedTask)
    {
        $this->savedTasks = $savedTask
            ->where('user_id', Auth::id())
            ->paginate(5);

        return view('livewire.settings', [
            'savedTasks' => $this->savedTasks,
        ]);
    }

    public function destroy(SavedTask $savedTask)
    {
        if ($savedTask->status) {
            $savedTask->status = 0;
            $savedTask->save();
        } else {
            $savedTask->status = 1;
            $savedTask->save();
        }
    }

    public function edit($id)
    {
        if ($id) {
            $this->sT = SavedTask::where('id', $id)
                ->where('user_id', Auth::id())
                ->get()
                ->toArray();
            //dd($this->sT[0]['task_name']);
            $this->taskName = $this->sT[0]['task_name'];
            $this->priority = $this->sT[0]['priority'];
            $this->type = $this->sT[0]['type'];
            $this->time = $this->sT[0]['time'];
            $this->taskId = $id;
        }
    }

    public function update()
    {
        //dd($this->taskName);
        /*$validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);*/

        if (Auth::id()) {
            //check the condithion
            $savedTask = SavedTask::find($this->taskId);
            //dd($savedTask);
            $savedTask->update([
                'task_name' => $this->taskName,
                'type' => $this->type,
                'priority' => $this->priority,
                'time' => $this->time,
            ]);
            session()->flash('message', 'Users Updated Successfully.');
        }
    }

    public function getInfo($id)
    {
        $this->info = TSS::getInfo($id);
        //dd($this->info);
    }

    public function getNote($id)
    {
        $this->notes = SNS::getNote($id);
        // dd($this->notes );
    }

    public function clearNotes($id=null)
    {
        if($id != null)
        {
            SNS::clearNotes($id);
            $this->notes = SNS::getNote($id)->except($id);
        }else{
            return;
        }
        
    }
}
