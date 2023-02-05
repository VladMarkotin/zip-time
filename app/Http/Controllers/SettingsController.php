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
        $notifications = [];
        $count_notifications = '';
        return view('settings', [
            'notifications' => $notifications,
            'count_notifications' => $count_notifications,
        ]);
    }
}
