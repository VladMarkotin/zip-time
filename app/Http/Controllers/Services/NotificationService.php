<?php

namespace App\Http\Controllers\Services;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationService 
{
    

    public function saveNotification(Request $request)
    {
        $id = auth()->id();
        $notification = new Notification();
        $notification->user_id = $id;
        $notification->type = $request->type;
        $notification->data = $request->data;
        $notification->notification_date = $request->notification_date;
        $notification->read_at = 0;
        $notification->save();
    }

   
}