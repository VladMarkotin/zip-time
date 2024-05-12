<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\NotificationService;



class NotificationController extends Controller
{

    private $notificationService ;

    public function __construct(NotificationService $notificationService )
    {
        $this->notificationService   = $notificationService;
    }


    public function notificationsHistory()
    {
        return view('notifications');
    }

    
    public function saveSubscription(Request $request)
    {
        $this->notificationService->saveSubscription($request);
    }

  


   

 










}
