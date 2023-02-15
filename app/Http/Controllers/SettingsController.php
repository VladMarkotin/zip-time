<?php

namespace App\Http\Controllers;


use Auth;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\Notifications;
use App\Http\Controllers\Services\SettingsService;
use App\Http\Controllers\Services\NotificationService;

class SettingsController extends Controller
{
    private $settingsService = null;
    private $notificationService;

    public function __construct(SettingsService $settingsService,  NotificationService $notificationService)
    {
        $this->settingsService = $settingsService;
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)  
    {
        $tasks = [];
        $notificatiions = $this->notificationService->getNotifications();
        return view('settings', [

            'tasks'               =>  $tasks,
            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);

    }
    }
