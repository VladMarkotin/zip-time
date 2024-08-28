<?php

namespace App\Http\Livewire;


use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\SavedTask;
use Carbon\CarbonImmutable;
use Livewire\WithPagination;
use App\Models\DefaultConfigs;
use App\Models\TimetableModel;
use App\Models\PersonalConfigs;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\LWServices\TaskStatService as TSS;
use App\Http\Livewire\LWServices\SavedNoteService as SNS;

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
    public $taskName, $type, $priority, $time, $taskId, $timezone, $setWeekendDays, $minMark, $minFinalMark, $minJobAmount, $config; //for updates

    public function __construct() {
       $this->emitRerender();
    }

    public function render(SavedTask $savedTask)
    {

        $this->savedTasks = $savedTask
            ->where('user_id', Auth::id())
            ->paginate(5);
        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $currentTimezone = User::where('id', Auth::id())->pluck('timezone')->toArray();

        // $currentPersonalWeekendDays = json_decode(DefaultConfigs::select('config_data')->where('config_block_id', 2)->where('user_id', Auth::id())
        // ->get()->toArray()[1]['config_data'])
        //     ->rules[0]->weekends;

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
        $this->emitRerender();

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

    public function updatedTimezone()
    {
        $user = User::find(Auth::id());
        $user->timezone = $this->timezone;
        $user->update();
        $this->dispatchBrowserEvent('message', [
            'text' => 'Timezone updated Successfully',
        ]);
    }

    public function UpdatedSetWeekendDays()
    {
        if ($this->config['isWeekendTaken'] == null) {
            $now = CarbonImmutable::now();
            $weekEndDate = $now->endOfWeek()->endOfDay();
            $personalConfigs = PersonalConfigs::getConfigs();
            $updated_at = json_decode($personalConfigs->last_updates);

            if ($now->gt($updated_at->weekend_updated_at)) {
                $data = json_decode($personalConfigs->config_data);
                $data->rules[0]->weekends = $this->setWeekendDays;
                $updated_at = json_decode($personalConfigs->last_updates);
                $updated_at->weekend_updated_at = $weekEndDate;
                $personalConfigs->config_data = json_encode($data);
                $personalConfigs->last_updates = json_encode($updated_at);
                $personalConfigs->save();
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Number of days off has been set.',
                ]);
            } else {
                $this->dispatchBrowserEvent('message', [
                    'text' => 'Already set for this week',
                ]);
            }
        }
    }

    public function updatedMinJobAmount()
    {
        $personalConfigs = PersonalConfigs::getConfigs();
        $data = json_decode($personalConfigs->config_data);
        $data->rules[0]->minRequiredTaskQuantity = $this->minJobAmount;
        $personalConfigs->config_data = json_encode($data);
        $personalConfigs->save();
        $this->dispatchBrowserEvent('message', [
            'text' => 'required jobs amount has been set ',
        ]);
    }

    public function mount()
    {

        $timetablemodel = new TimetableModel;
        $isWeekendTaken = $timetablemodel->isWeekendTaken();
        $this->config['isWeekendTaken'] =  $isWeekendTaken;

        $isDayPlanCompleted = $timetablemodel->isDayPlanCompleted();
        $this->config['isDayPlanCompleted'] =  $isDayPlanCompleted;

        $data = DefaultConfigs::getConfigs();
     
        $defaultConfigs = json_decode(($data)[1]->config_data)->rules[0];
        $this->config['defaultConfigs'] = get_object_vars($defaultConfigs);

        $data = PersonalConfigs::getConfigs();
        $personalRulesConfigs = json_decode($data->config_data)->rules[0];
        $personalUpdatedAt = json_decode($data->last_updates);
        $this->config['personalConfigs']['rules'] = get_object_vars($personalRulesConfigs);
        $this->config['personalConfigs']['time_stamps'] = get_object_vars($personalUpdatedAt);

        // $this->minMark = $this->config['personalConfigs']['minFinalMark'];
        $this->setWeekendDays = $this->config['personalConfigs']['rules']['weekends'];
        $this->minJobAmount = $this->config['personalConfigs']['rules']['minRequiredTaskQuantity'];
        //   dd(  $this->config);
    }

    public function cancel()
    {}

    private function emitRerender() 
    {
        //создаю событие, что бы перехватить его на фронте и заново проинитить нужные мне классы
        $this->emit('rerender');
    }
}
