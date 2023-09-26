<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Tasks;
use Livewire\Component;
use App\Models\Notification;
use App\Models\TimetableModel;
use App\Events\NotificationEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dropdown extends Component
{
    public  $type , $date, $data, $unread;
    protected $listeners = ['refresh' => '$refresh', 'saveNotification'];
    protected $rules = [
        'type' => 'required',
        'date' => 'required',
        'data' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function readNotification($id)
    {
        Notification::findOrfail($id)->update(['read_at' => 1]);
        $this->emit('refresh');
    }

    public function deleteNotification($id)
    {
        Notification::find($id)->delete();
        $this->emit('refresh');
    }

    public function saveNotification($type = null, $data = null, $date = null)
    {
          
        !$data ? $this->validate() : '';
        $notification = Notification::create([
            'user_id' => auth()->user()->id,
            'type' => $type ? $type : $this->type,
            'data' =>     $data ? $data : $this->data,
            'notification_date' =>   $date ? $date : $this->date,
            'broadcast_type' => !$data ? 'private' : 'public',
            'read_at' => 0
        ]);
        $this->emit('refresh');
        $this->reset(['type', 'date', 'data']);
        $this->dispatchBrowserEvent('close-modal');
    }

    public function addTask($id)
    {
        $notification = Notification::find($id);
        $timetable = TimetableModel::where('user_id', Auth::id())
            ->where('date', Carbon::today())
            ->first();

        if ($timetable) {
            $dataForTasks = [
                "timetable_id" => $timetable->id,
                "hash_code"    => '#',
                "task_name"    =>  $notification->type,
                "type"         => 1,
                "priority"     => 2,
                "details"     => $notification->data,
                "time"         => '00:00',
                "mark"         => -1,
                "created_at"   => DB::raw('CURRENT_TIMESTAMP(0)'),
                "updated_at"   => DB::raw('CURRENT_TIMESTAMP(0)')
            ];
            Tasks::insert($dataForTasks);
            return redirect()->route('home');
        } else {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Create a Day Plan',
            ]);
        }
    }

    public function pushNotification()
    {

        $this->validate();
        event(new NotificationEvent($this->type,  $this->data,  $this->date));
        $this->dispatchBrowserEvent('close-modal');
        $this->reset(['type', 'date', 'data']);
    }


    public function render()
    {

        $id = auth()->id();
        $ldate = date('Y-m-d');
        $notifications = Notification::where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->orderBy('created_at', 'DESC')
            ->when($this->unread, function ($e) {
                $e->where('read_at', 0);
            })
            ->take(15)
            ->get();
        return view('livewire.dropdown', [

            'notifications' => $notifications,

        ]);
    }
}
