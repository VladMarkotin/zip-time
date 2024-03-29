<?php

namespace App\Http\Controllers\Services;

use App\Events\NotificationEvent;
use App\Events\Notifications;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationService 
{
    public function sendNotification(Request $request)
    {
        $notification = $request->all();
        $request->validate([
         
            'data_pusher' => 'filled|required',
            'notification_date_pusher' => 'filled|required',
        ]);

        $type = $notification['type_pusher'];
        $data = $notification['data_pusher'];
        $date = $notification['notification_date_pusher'];

         event(new NotificationEvent($type, $data, $date));

     }

    public function readNotification(Request $request)
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $notification_content = [$request->input('notification_content')];
        Notification::where('user_id', $id)
            ->where('data', $notification_content)
            ->update(['read_at' => 1]);

        $count_notifications = Notification::all()
            ->where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)
            ->count();

        $response = ['count_notifications' => $count_notifications];
        return $response;
    }

    public function saveNotification(Request $request)
    {
          
        
        $request->validate([
            'type' => 'filled|required',
            'data' => 'filled|required',
            'notification_date' => 'filled|required',
        ]);

 

        $id = auth()->id();

        $notification = new Notification();
        $notification->user_id = $id;
        $notification->type = $request->type;
        $notification->data = $request->data;
        $notification->notification_date = $request->notification_date;
        $notification->read_at = 0;
        $notification->save();
    }

    public function getNotifications()
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $count_notifications = Notification::all()
            ->where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)
            ->count();
        $notifications = Notification::
              where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)
            ->orderBy('created_at', 'DESC')
            ->take(15)
            ->get();
        //dd("error");
        return [
            'count_notifications' => $count_notifications,
            'notifications' => $notifications,
        ];
    }
}