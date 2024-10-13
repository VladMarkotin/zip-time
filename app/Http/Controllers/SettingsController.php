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

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index(Request $request)
    {
        return view('settings', [
            'timezones' => "Europe/Minsk",
        ]);
    }

    public function saveNotificationsConfigs(Request $request)
    {
        $fields = [
            'config_data' => json_encode(
                [
                    'notifies_config' => [[
                        'quantity' => strval($request->get('additionalNotificationsCount')),
                        'enable' => strval(intval($request->get('areNotifiactionsActive'))),
                    ]]
                ]
            ),
        ];
        $this->settingsService->saveNotitifcationSettings($fields);
    }
}
