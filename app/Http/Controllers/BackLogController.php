<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\Notifications;
use App\Notifications\UserNotification;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Services\RatingService;
use App\Http\Controllers\Services\NotificationService;

class BackLogController extends Controller
{
    private $notificationService;


    public function __construct(  NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

    }

    public function index()
    {
        $notificatiions = $this->notificationService->getNotifications();

        return view('backlog', [
            
            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);
    }
}
