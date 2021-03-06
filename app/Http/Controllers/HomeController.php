<?php

namespace App\Http\Controllers;

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
        return view('home');
    }
}
