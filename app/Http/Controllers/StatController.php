<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\StatService;
use App\Http\Controllers\Services\NotificationService;

class StatController extends Controller
{
    private $statService = null;
    private $notificationService;

    public function __construct(StatService $statService,  NotificationService $notificationService )
    {
        $this->notificationService = $notificationService;
        $this->statService = $statService;
    }


    
    public function index()
    {
        $notificatiions = $this->notificationService->getNotifications();
        return view('stat',  [

            'count_notifications' => $notificatiions['count_notifications'],
            'notifications' => $notificatiions['notifications'],
        ]);
    }

    public function getStatData(Request $request = null)
    {
        if (!$request) {
            $response = $this->statService->getStat();
        } else {
            $data['from'] = $request->get('from');
            $data['to'] = $request->get('to');
            $response = $this->statService->getStat($data);
        }
        $response['marks']['finalMarks'] = array_values(
            $response['marks']['finalMarks']
        );
        $response['marks']['ownMarks'] = array_values(
            $response['marks']['ownMarks']
        );
        $response = json_encode($response, JSON_UNESCAPED_UNICODE);

        return $response;
    }

    public function getStatInfo(Request $request)
    {
        //dd($request->get('from'));
        if (!$request) {
            $response = $this->statService->getStat();
        } else {
            $data['from'] = $request->get('from');
            $data['to'] = $request->get('to');
            $response = $this->statService->getStat($data);
        }
        $response['marks']['finalMarks'] = array_values(
            $response['marks']['finalMarks']
        );
        $response['marks']['ownMarks'] = array_values(
            $response['marks']['ownMarks']
        );
        $response = json_encode($response, JSON_UNESCAPED_UNICODE);

        return $response;
    }
}
