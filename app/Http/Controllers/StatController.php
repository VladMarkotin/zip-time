<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\StatService;

class StatController extends Controller
{
    private $statService = null;

    public function __construct(StatService $statService)
    {
        $this->statService = $statService;
    }

    public function index(Request $request = null)
    {
        if(!$request){
            $response = $this->statService->getStat();
        } else{
            $data["from"]            = $request->get('from');
            $data["to"]              = $request->get('to');
            $data["date"]            = ($data["date"]) ? $request->get('date') : null;
            $data["with_failed"]     = $request->get('with_failed');
            $data["with_weekend"]    = $request->get('with_weekend');
            $data["with_emergency"]  = $request->get('with_emergency');
            $response                = $this->statService->getStat($data);
        }
        $response = json_encode($response, JSON_UNESCAPED_UNICODE);

        return $response;
    }
}
