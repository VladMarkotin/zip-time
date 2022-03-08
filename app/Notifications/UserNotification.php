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
    public function __construct($remindModel = null)//$remind
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
            'type'    => '1', //0-system, 1 - user`s
            'data'    => $this->remindModel['text'],
            'date'    => $this->remindModel['date'],
            'time'    => $this->remindModel['time'],
        ];
    }
}
