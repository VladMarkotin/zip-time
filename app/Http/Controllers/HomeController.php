<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SavedTask;
use App\Models\PushNotification;
use Illuminate\Http\Request;
use App\Events\Notifications;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EstimationRepository;
use App\Http\Controllers\Services\RatingService;
use App\Http\Controllers\Services\GetDayPlanService;

use App\Http\Controllers\Services\IndexStatServices\IndexStatService;


class HomeController extends Controller
{
    private $indexStatService = null;

    public function __construct(IndexStatService $indexStatService)
    {
        $this->indexStatService = $indexStatService;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $statData = $this->indexStatService->countStatIndex();

    
        return view('home')->with(['statData' => $statData]);
    }















}
