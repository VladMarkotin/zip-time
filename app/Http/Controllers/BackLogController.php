<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Models\Notification;
use App\Notifications\UserNotification;
use App\Http\Controllers\Services\RatingService;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;

class BackLogController extends Controller
{
    public function __construct(UserNotification $userNotification,
                                RatingService $userRatings,
                                NotificationController $notiController )
    {
        $this->userNotification          = $userNotification;
        //dd($userNotification);
        $this->userRatings               = $userRatings;
        $this->notificationController    = $notiController;
    }

    public function index()
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $count_notifications = Notification::all()->where('user_id', $id)->where('notification_date', '<=', $ldate)->where('read_at', 0)->count();
        $notifications = Notification::all()
            ->where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)->all();

        return view('backlog', [
            'count_notifications' => $count_notifications,
            'notifications' => $notifications,
        ]);
    }
}
