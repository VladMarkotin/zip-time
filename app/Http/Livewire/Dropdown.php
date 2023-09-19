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

    
    public  $type, $date, $data, $unread;
    protected $listeners = [ 'refresh'=>'$refresh'];
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

    public function saveNotification()
    {
        $validatedData = $this->validate();
        $notification = Notification::create([
            'user_id' => auth()->user()->id,
            'type' => $this->type,
            'data' => $this->data,
            'notification_date' => $this->date,
            'read_at' => 0
        ]);
        $this->emit('refresh');
        $this->dispatchBrowserEvent('close-modal');
    }

    public function addTask($id)
    {
        $notification = Notification::find($id)->first();
      
        $timetable = TimetableModel::where('user_id', Auth::id())
        ->where('date', Carbon::today())
        ->first();
       
        if($timetable){
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
        }else{
            $this->dispatchBrowserEvent('message', [
                'text' => 'Please Create a Day Plan',
            ]);
           
        }

       
    }

    public function pushNotification()
    {
       $broadcast = event(new NotificationEvent('pusher',  $this->data,  $this->date));
       dd($broadcast );
    }





    
    public function render()
    {

        $id = auth()->id();
        $ldate = date('Y-m-d');
        $notifications = Notification::where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->orderBy('created_at', 'DESC')
            ->when($this->unread,function($e){
                $e->where('read_at', 0);
            })
            ->take(15)
            ->get();
        return view('livewire.dropdown', [

            'notifications' => $notifications,

        ]);
    }
}
