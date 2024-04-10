<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Events\DailyReminder;
use App\Models\TimetableModel;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function notificationsHistory()
    {
        return view('notifications');
    }

}
