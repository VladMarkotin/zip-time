<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\HistService;
use App\Http\Controllers\Services\NotificationService;

class HistController extends Controller
{
    private $histService = null;

    public function __construct(HistService $histService,
                                NotificationService $notificationService
                                )
    {
        $this->histService = $histService;
        $this->notificationService = $notificationService;
    }

    public function displayHist()
    {
        $tasks = [];
        $notificatiions = $this->notificationService->getNotifications();
        return view('hist', [

            'tasks'               =>  $tasks,
            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);
    }

    public function index(Request $request)
    {
        
        $startDate = $request->start_date;
        $response = $this->histService->getHist($startDate);
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
}
