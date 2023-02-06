<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Notifications extends Component
{
    public $type;
    public $data;
    public $endDate;
    public $startDate;   
    public $notificationId;
    public $tasks             = [];
    public $notifications     = [];
    public $sortNotifications = [];

    public function mount(): void
    {
        if (empty($this->sortNotifications)) {
            $this->sortNotifications[] = 'all';
        }
       // $this->notifications = $notifications;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|max:80',
            'data' => 'required|string',
        ];
    }

    public function resetInput(): void
    {
        $this->type = null;
        $this->data = null;
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
    }

    public function updateNotification(): void
    {
        $validatedData = $this->validate();
        Notification::findOrFail($this->notificationId)->update([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'data' => $this->data,
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

    public function render()
    {
        $this->notifications = Notification::where('user_id', Auth::id())

            // ->when(
            //     $this->startDate == $this->startDate &&
            //         $this->endDate == $this->endDate,
            //     function ($e2) {
            //         $e2->whereBetween('notification_date', [
            //             $this->startDate,
            //             $this->endDate,
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

            ->get();

        return view('livewire.notifications');
    }
}




















