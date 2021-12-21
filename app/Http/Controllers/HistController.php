<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Services\HistService;

class HistController extends Controller
{
    private $histService = null;

    public function __construct(HistService $histService)
    {
        $this->histService = $histService;
    }

    public function index(Request $request = null)
    {
        if(!$request){
            $response = $this->histService->getHist();
            dd($response);
        } else{
            $data["from"]           = $request->get('from');
            $data["to"]             = $request->get('to');
            $data["with_failed"]    = $request->get('with_failed');
            $data["with_weekend"]   = $request->get('with_weekend');
            $data["with_emergency"] = $request->get('with_emergency');
            $response = $this->histService->getHist($data);
            dd($response);
        }

    }
}
