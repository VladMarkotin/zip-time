<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SavedTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Events\Notifications;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EstimationRepository;
use App\Http\Controllers\Services\RatingService;
use App\Http\Controllers\Services\GetDayPlanService;
use App\Http\Controllers\Services\NotificationService;

class HomeController extends Controller
{
    private $userRatings   = null;
    private $estimateDayRepository = null;
    private $getDayPlanService = null;
    private $notificationService;
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GetDayPlanService $getDayPlanService, EstimationRepository $estimationRepository, RatingService $userRatings, NotificationService $notificationService  )
    { $this->userRatings = $userRatings;
     
        $this->estimateDayRepository = $estimationRepository;
        $this->notificationService = $notificationService;
        //$this->middleware('auth');
        $this->getDayPlanService = $getDayPlanService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tasks = [];
        $notificatiions = $this->notificationService->getNotifications();
        return view('home', [

            'tasks'               =>  $tasks,
            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);

    }
}
