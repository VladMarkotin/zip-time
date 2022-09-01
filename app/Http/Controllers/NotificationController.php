<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {

        $id = auth()->id();
        $ldate = date('Y-m-d');
        $notifications = Notification::all()
            ->where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)->all();

        foreach ($notifications as $value){

            $notification_id = $value['id'];
            $type = $value['type'];
            $data = $value['data'];

            event(new Notifications($notification_id, $type, $data));

        }

    }

    public function readNotification(Request $request)
    {
        $id = auth()->id();
        $notification_content = [$request->input('notification_content')];
        Notification::where('user_id', $id)
            ->where('data', $notification_content)
            ->update(['read_at' => 1]);

        $count_notifications = Notification::all()->where('user_id', $id)->where('read_at', 0)->count();

        $notificationInfo = ['count_notifications' => $count_notifications];
        echo json_encode($notificationInfo);

    }

}
