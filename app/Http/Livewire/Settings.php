<?php
namespace App\Http\Livewire;


use Livewire\Component;
use App\Models\SavedTask;
use App\Models\SavedNotes;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\LWServices\TaskStatService as TSS;
use App\Http\Livewire\LWServices\SavedNoteService as SNS;
use App\Models\User;

class Settings extends Component
{
    use WithPagination;

    public $noteID;
    public $info = [];
    public $notes = [];
    private $savedTasks = [];
    public $selectedNotes = []; 
    public $selectAll = false; 
    public $removeDeletedNote;
    public $sT = null;
    public $taskName, $type, $priority, $time, $taskId, $timezone; //for updates

    public function render(SavedTask $savedTask)
    {
       
        $this->savedTasks = $savedTask
            ->where('user_id', Auth::id())
            ->paginate(5);
        $timezones = \DateTimeZone::listIdentifiers( \DateTimeZone::ALL );
        $currentTimezone = User::where('id', Auth::id())->pluck('timezone')->toArray();
        $this->timezone = $currentTimezone;

        return view('livewire.settings', [
            'savedTasks' => $this->savedTasks,
            'timezones' => $timezones,
            'currentTz' => $currentTimezone[0],
            'user_id'   => Auth::id(),
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

    public function update($tz = null)
    {
        if (Auth::id() && (!$tz)) {
            //check the condithion
            $savedTask = SavedTask::find($this->taskId);
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
        sleep(1);
        $this->noteID = $id;
        $this->notes = SNS::getNote($id);
        $this->removeDeletedNote = SNS::getNote($id);
        //dd($this->notes1 );
    }

    public function clearNotes()
    {
        if ($this->selectedNotes !== null) {
            SNS::clearNotes($this->selectedNotes);
            $this->notes = $this->removeDeletedNote->except(
                $this->selectedNotes
            );
        } else {
            return;
        }
        $this->selectedNotes = [];
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedNotes = SNS::selectAll($this->noteID);
        } else {
            $this->selectedNotes = [];
        }
    }

    public function change()
    {
        $user = User::find( Auth::id());
        $user->timezone = $this->timezone;
        $user->update();
        $this->dispatchBrowserEvent('message', [
            'text' => 'Timezone updated Successfully',
        ]);
    }
}
