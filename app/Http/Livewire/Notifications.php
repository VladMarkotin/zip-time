<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class Notifications extends Component
{
    use WithPagination;
    public $type;
    public $data;
    public $date;
    public $search='';
    public $endDate;
    public $startDate;
    public $notificationId;
    public $tasks = [];
    public $sortNotifications = [];
    protected $paginationTheme = 'bootstrap';

    public function mount(): void
    {
        $this->resetPage();
        if (empty($this->sortNotifications)) {
            $this->sortNotifications[] = 'all';
        }
    }

    
    
    public function rules(): array
    {
        return [
            'type' => 'required|string|max:80',
            'data' => 'required|string',
            'date' => 'required|string',
        ];
    }

    public function resetInput(): void
    {
        $this->type = null;
        $this->data = null;
        $this->date = null;
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }





    public function editNotification($notificationId): void
    {
        $this->notificationId = $notificationId;
        $notification = Notification::findOrfail($notificationId);
        $this->type = $notification->type;
        $this->data = $notification->data;
        $this->date = $notification->notification_date;
    }

    public function readNotification($id)
    {
        $notification = Notification::findOrfail($id);
        if ($notification->read_at == 0) {
            $notification->read_at = 1;
            $notification->update();
        }
    }

    public function updateNotification(): void
    {
        $validatedData = $this->validate();
        Notification::findOrFail($this->notificationId)->update([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'data' => $this->data,
            'notification_date' => $this->date,
        ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('message', [
            'text' => 'Notification Updated Successfully',
        ]);
        $this->resetInput();
    }

    public function deleteNotification($notificationId): void
    {
        $this->notificationId = $notificationId;
    }

    public function destroyNotification(): void
    {
        Notification::find($this->notificationId)->delete();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('message', [
            'text' => 'Notification Deleted Successfully',
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSortNotifications()
    {
        $this->resetPage();
    }
    

    public function render()
    {
        $notification = Notification::where('user_id', Auth::id())

            ->when($this->search , function ($e2) {
                $e2
                    ->where('data', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%');
            })
            ->when(
                $this->startDate !== null && $this->endDate !== null,
                function ($e2) {
                    $e2->whereBetween('notification_date', [
                        $this->startDate,
                        $this->endDate,
                    ]);
                }
            )

            
            // ->when($this->period()['startDate'] !== null || $this->period()['endDate'] !== null,
            //     function ($e2) {
            //         $e2->whereBetween('notification_date', [
            //             $this->period()['startDate'],
            //             $this->period()['endDate'],
            //         ]);
            //     }
            // )

            ->when($this->sortNotifications, function ($e) {
                $e
                    ->when($this->sortNotifications == 'read', function ($e2) {
                        $e2
                            ->where('read_at', 1)
                            ->orderBy('notification_date', 'DESC');
                    })
                    ->when($this->sortNotifications == 'unread', function (
                        $e2
                    ) {
                        $e2
                            ->where('read_at', 0)
                            ->orderBy('notification_date', 'DESC');
                    })
                    ->when($this->sortNotifications == 'all', function ($e2) {
                        $e2->orderBy('notification_date', 'DESC');
                    });
            })
        ->orderBy('notification_date', 'DESC')
        ->paginate(4);

        return view('livewire.notifications', ['notifications'=> $notification]
        );
    }
}