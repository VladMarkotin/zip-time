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
    private $notificationService;
    private $estimationRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService, EstimationRepository $estimationRepo )
    {
        $this->notificationService = $notificationService;
        $this->estimationRepo = $estimationRepo;
        $this->middleware('auth');
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
            'tasks' => $tasks,
            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);
    }
}
