<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\SavedTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EstimationRepository;
use App\Http\Controllers\Services\RatingService;
use App\Http\Controllers\Services\GetDayPlanService;

class HomeController extends Controller
{
    private $userRatings   = null;
    private $estimateDayRepository = null;
    private $getDayPlanService = null;
  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GetDayPlanService $getDayPlanService, EstimationRepository $estimationRepository, RatingService $userRatings  )
    { $this->userRatings = $userRatings;
     
        $this->estimateDayRepository = $estimationRepository;
        
        $this->middleware('auth');
        $this->getDayPlanService = $getDayPlanService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $count_notifications = Notification::all()->where('user_id', $id)->where('notification_date', '<=', $ldate)->where('read_at', 0)->count();
        $notifications = Notification::all()
            ->where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)->all();
        //dd("error");
        return view('home', [
            'count_notifications' => $count_notifications,
            'notifications' => $notifications,
        ]);

    }

    public function markovIndex()
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $count_notifications = Notification::all()->where('user_id', $id)->where('notification_date', '<=', $ldate)->where('read_at', 0)->count();
        $notifications = Notification::all()
            ->where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)->all();
        //dd("error");
        return view('markov-index', [
            'count_notifications' => $count_notifications,
            'notifications' => $notifications,
        ]);

    }

    public function kateIndex()
    {
        $id = auth()->id();
        $ldate = date('Y-m-d');
        $count_notifications = Notification::all()->where('user_id', $id)->where('notification_date', '<=', $ldate)->where('read_at', 0)->count();
        $notifications = Notification::all()
            ->where('user_id', $id)
            ->where('notification_date', '<=', $ldate)
            ->where('read_at', 0)->all();
        //dd("error");
        return view('kate_index', [
            'count_notifications' => $count_notifications,
            'notifications' => $notifications,
        ]);

    }
}
