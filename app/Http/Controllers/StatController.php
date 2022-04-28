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
            $response                = $this->statService->getStat($data);
        }
        $response = json_encode($response, JSON_UNESCAPED_UNICODE);

        return $response;
    }
}
