<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {

        $notification = $request->all();

        $type = $notification['type'];
        $data = $notification['data'];
        $date = $notification['notification_date'];

        event(new Notifications($type, $data, $date));

    }

    public function readNotification(Request $request)
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $notification_content = [$request->input('notification_content')];
        Notification::where('user_id', $id)
            ->where('data', $notification_content)
            ->update(['read_at' => 1]);

        $count_notifications = Notification::all()->where('user_id', $id)->where('notification_date', '<=', $ldate)->where('read_at', 0)->count();

        $notificationInfo = ['count_notifications' => $count_notifications];
        echo json_encode($notificationInfo);

    }

    public function saveNotification(Request $request)
    {
        $request->validate([
            'type' => 'filled|required',
            'data' => 'filled|required',
            'notification_date' => 'filled|required',
        ]);

        $id = auth()->id();

        $notification = new Notification;
        $notification->user_id = $id;
        $notification->type = $request->type;
        $notification->data = $request->data;
        $notification->notification_date = $request->notification_date;
        $notification->read_at = 0;
        $notification->save();

    }

}