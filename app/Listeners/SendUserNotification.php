<?php

namespace App\Listeners;

use App\Events\UserNotify;
use App\Notifications\UserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\UserNotify as UNotify;
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
     *
     * @param  \App\Events\UserNotify  $event
     * @return void
     */
    public function handle(UNotify $event)
    {
        $users = UNotify::whereHas('roles', function ($query){
           $query->where('user_id', Auth::id());
        })->get();

        Notification::send($users, new UserNotification($event->user));
    }
}
