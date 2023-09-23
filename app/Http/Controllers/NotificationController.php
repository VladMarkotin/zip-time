<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function notificationsHistory()
    {
        return view('notifications');
    }
}