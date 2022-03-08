<?php

namespace App\Listeners;


use App\Notifications\UserNotification as UNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\RemindModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SendUserNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * Here will handle the event
     * @param  \App\Events\UserNotify  $event
     * @return void
     */
    public function handle(UNotify $event)
    {
        $user = RemindModel::where('user_id', Auth::id())->get()->toArray();
        Notification::send($user, $event);
    }
}
