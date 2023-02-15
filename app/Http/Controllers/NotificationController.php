<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\Notifications;
use App\Http\Controllers\Services\NotificationService;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function sendNotification(Request $request)
    {
        $this->notificationService->sendNotification($request);
    }

    public function readNotification(Request $request)
    {
        $response = $this->notificationService->readNotification($request);

        echo json_encode($response);
    }

    public function saveNotification(Request $request)
    {
        $this->notificationService->saveNotification($request);
    }
    
    public function notificationsHistory()
    {
        $tasks = [];
        $notificatiions = $this->notificationService->getNotifications();
        return view('notifications', [
            'tasks'               =>  $tasks,
            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);
    }
}