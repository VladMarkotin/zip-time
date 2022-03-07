<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\RemindModel;

class UserNotification extends Notification
{
    use Queueable;

    private $remindModel = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RemindModel $remindModel)//$user
    {
        $this->remindModel = $remindModel;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        //This array responsible for containing fields which will storage in db
        //So I need to place notification info here
        return [
            'userId'   => Auth::id(),
            'date'     => $this->remindModel->date,
            'time'     => $this->remindModel->time,
            'text'     => $this->remindModel->text,
            'isActive' => $this->remindModel->is_active
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'userId'   => Auth::id(),
            'date'     => $this->remindModel->date,
            'time'     => $this->remindModel->time,
            'text'     => $this->remindModel->text,
            'isActive' => $this->remindModel->is_active,
            'userNotifyTime' => Carbon::now(),
        ];
    }
}
