<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\StatService;


class StatController extends Controller
{
    private $statService = null;
  

    public function __construct(StatService $statService )
    {
       
        $this->statService = $statService;
    }


    
    public function index()
    {
        return view('stat');

    }

    public function getStatData(Request $request)
    {
        $data['from'] = $request->get('from');
        $data['to']   = $request->get('to');
        
        if ($data['from'] === null || $data['to'] === null) {
            $response = $this->statService->getStat();
        } else {
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
