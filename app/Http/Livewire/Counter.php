<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;

class Counter extends Component
{
    public $counter =5555;
    protected $listeners = [ 'refresh'=>'$refresh'];

  
    public function render()
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $this->counter = Notification::
          where('user_id', $id)
        ->where('notification_date', '<=', $ldate)
        ->where('read_at', 0)
        ->count();
        return view('livewire.counter');
    }
}
