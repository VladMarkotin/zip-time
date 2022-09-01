<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Models\Notification;
use App\Http\Controllers\Services\GetDayPlanService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $getDayPlanService = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GetDayPlanService $getDayPlanService)
    {
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

        return view('home', [
            'count_notifications' => $count_notifications,
        ]);

    }
}
