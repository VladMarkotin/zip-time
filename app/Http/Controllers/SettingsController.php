<?php

namespace App\Http\Controllers;


use Auth;
use App\Events\Notifications;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\SettingsService;

class SettingsController extends Controller
{
    private $settingsService = null;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index(Request $request)
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $count_notifications = Notification::all()->where('user_id', $id)->where('notification_date', '<=', $ldate)->where('read_at', 0)->count();
        $notifications = Notification::all()
            ->where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)->all();

        return view('settings', [
            'count_notifications' => $count_notifications,
            'notifications' => $notifications,
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
