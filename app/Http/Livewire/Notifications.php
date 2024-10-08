<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Notifications extends Component
{
    use WithPagination;
    public $type;
    public $data;
    public $date;
    public $search = '';
    public $endDate;
    public $startDate;
    public $notificationId;
    public $tasks = [];
    public $sortNotifications = ['all'];
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh' => '$refresh'];

    public function mount(): void
    {
        $this->resetPage();
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|max:80',
            'data' => 'required|string',
            'date' => 'required|string',
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function readNotification($id)
    {
        Notification::findOrfail($id)->update(['read_at' => 1]);
        $this->emit('refresh');
    }

    public function editNotification($notificationId): void
    {
        $this->notificationId = $notificationId;
        $notification = Notification::findOrfail($notificationId);
        $this->type = $notification->type;
        $this->data = $notification->data;
        $this->date = $notification->notification_date;
    }

    public function updateNotification(): void
    {
        $this->validate();
        Notification::findOrFail($this->notificationId)->update([
            'user_id' => Auth::id(),
            'type' => $this->type,
            'data' => $this->data,
            'broadcast_type' => 'private',
            'notification_date' => $this->date,
        ]);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('message', [
            'text' => 'Notification Updated Successfully',
        ]);
        $this->emit('refresh');
        $this->reset(['type', 'date', 'data']);
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
        $this->emit('refresh');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSortNotifications()
    {
        $this->resetPage();
    }
    public function updatingEndDate()
    {
        $this->resetPage();
    }


    public function render()
    {
        $notification = Notification::where('user_id', Auth::id())

            ->when(
                $this->startDate !== null && $this->endDate !== null,
                function ($e2) {
                    $e2->whereBetween('notification_date', [
                        $this->startDate,
                        $this->endDate


                    ]);
                }
            )

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

            ->when($this->search, function ($e2) {
                $e2
                    ->where('data', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%');
            })

            ->orderBy('created_at', 'DESC')
            ->paginate(4);
        $count = Notification::where('user_id', Auth::id())->get();
        $count_unread = $count->where('read_at', 0)->count();
        $count_read = $count->where('read_at', 1)->count();
        $total = $count->count();
        return view('livewire.notifications', [
            'notifications' => $notification,
            'count_unread' => $count_unread,
            'count_read' => $count_read,
            'total' => $total,
        ]);
    }
}
