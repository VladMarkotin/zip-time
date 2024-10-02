<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\HistService;
use Illuminate\Support\Facades\Auth;

class HistController extends Controller
{
    private $histService = null;

    public function __construct(HistService $histService )
    {
        $this->histService = $histService;
     
    }

    public function displayHist()
    {
        return view('hist');
    }

    public function index(Request $request)
    {
        
        $startDate = $request->start_date;
        $todayDate = $request->today_date;
        $response = $this->histService->getHist($startDate, $todayDate);
        //die(var_dump($response));
        return $response;
    }

    public function histOnDate(Request $request)
    {
        $data = $request->route()->parameters();
        $data["direction"] = $request->input('direction');
        $response = $this->histService->getHist($data);

        return $response;
    }

    public function getHistforClosedDay(Request $request) {
        $user_id = Auth::id();
        $date    = $request->date;
        $flag    = $request->flag;
        $pattern = "/^(\d{4}-\d{2}-\d{2})/";

        if (preg_match($pattern, $date, $matches)) {
            $formatedDate = $matches[0];   
            $response = $this->histService->getHistforClosedDay($formatedDate, $user_id, $flag);
            return response()->json($response);
        }

        return response()->json(['isDayMissed' => true]);
    }
}
