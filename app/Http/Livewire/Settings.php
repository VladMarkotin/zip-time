<?php

namespace App\Http\Livewire;


use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\SavedTask;
use App\Models\SavedNotes;
use Carbon\CarbonImmutable;
use Livewire\WithPagination;
use App\Models\DefaultConfigs;
use App\Models\TimetableModel;
use App\Models\PersonalConfigs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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
        // if((Cookie::get('weekend-days')) == null){
        // $defaultConfigs =DefaultConfigs::find(3);
        //     Cookie::queue(Cookie::make('weekend-days',  $now , $lifetime));
        //      $this->dispatchBrowserEvent('message', [
        //     'text' => 'weekend days set ',
        //      ]);         
        // }else{
        //      $this->dispatchBrowserEvent('message', [
        //     'text' => ' already set for this week',
        //      ]);      
        // } 

        if( $this->config['isWeekendTaken'] == null )
        {
            $personalConfigs = PersonalConfigs::getConfigs();
            $data = json_decode($personalConfigs->config_data);
            $data->rules[0]->weekends = $this->setWeekendDays;
            $personalConfigs->config_data = json_encode($data);
            $personalConfigs->save();
        }
      
    }


    public function minFinalMark()
    {
       
        if ($this->minMark >=  $this->config['defaultConfigs']['minFinalMark'] &&  $this->config['isDayPlanCompleted'] == null ) 
        {
            $personalConfigs = PersonalConfigs::getConfigs();
            $data = json_decode($personalConfigs->config_data);
            $data->rules[0]->minFinalMark = $this->minMark;
            $personalConfigs->config_data = json_encode($data);
            $personalConfigs->save();
        }
    }

    public function updatedMinJobAmount()
    {
        $personalConfigs = PersonalConfigs::getConfigs();
        $data = json_decode($personalConfigs->config_data);
        $data->rules[0]->minRequiredTaskQuantity = $this->minJobAmount;
        $personalConfigs->config_data = json_encode($data);
        $personalConfigs->save();
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
        $personalConfigs = json_decode($data->config_data)->rules[0];
        $this->config['personalConfigs'] = get_object_vars($personalConfigs);

        $this->minMark = $this->config['personalConfigs']['minFinalMark'];
        $this->setWeekendDays = $this->config['personalConfigs']['weekends'];
        $this->minJobAmount = $this->config['personalConfigs']['minRequiredTaskQuantity'];
    }
}
