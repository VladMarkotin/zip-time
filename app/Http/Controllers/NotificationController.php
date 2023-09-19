<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\NotificationService;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function saveNotification(Request $request)
    {
        $this->notificationService->saveNotification($request);
    }
    
    public function notificationsHistory()
    {
        return view('notifications');
    }
}