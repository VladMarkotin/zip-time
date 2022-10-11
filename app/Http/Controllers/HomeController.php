<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SavedTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\EstimationRepository;
use App\Http\Controllers\Services\RatingService;
use App\Http\Controllers\Services\GetDayPlanService;

class HomeController extends Controller
{

    private $estimateDayRepository = null;
    private $getDayPlanService = null;
    private $userRatings = null; 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(GetDayPlanService $getDayPlanService, RatingService $userRatings, EstimationRepository $estimationRepository)
    {
        $this->userRatings = $userRatings;
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
        return view('home');
    }
}
