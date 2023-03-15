<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SavedTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\Notifications;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EstimationRepository;
use App\Http\Controllers\Services\NotificationService;
use App\Repositories\TimezoneRepository;

class HomeController extends Controller
{
  
    private $estimateDayRepository = null;
    private $timezoneRepository = null;
    private $notificationService;
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TimezoneRepository $timezoneRepository, EstimationRepository $estimationRepository, NotificationService $notificationService  )
    { 
        $this->timezoneRepository = $timezoneRepository;
        $this->estimateDayRepository = $estimationRepository;
        $this->notificationService = $notificationService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->estimateDayRepository->getIds();
       // $this->timezoneRepository->getUsersInTimezone();
        $tasks = [];
        $notificatiions = $this->notificationService->getNotifications();
        return view('home', [

            'tasks'               =>  $tasks,
            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);

    }
}
