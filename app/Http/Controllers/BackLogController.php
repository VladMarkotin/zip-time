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
   
    public function index()
    {
       
        return view('backlog');

    }
}