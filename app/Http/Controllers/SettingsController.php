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
   
        $notificatiions = $this->notificationService->getNotifications();
        return view('settings', [

            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);
        /*$setting = ($request->route()->parameters());
        $params = ['id' => Auth::id()];
        $response = null;
        if($setting) {
            $params['option'] = $setting;
            $response = $this->settingsService->getAllSettings($params);
        }

        return json_encode($response, JSON_UNESCAPED_UNICODE);*/
    }
}
