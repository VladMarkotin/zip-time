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

    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $response = $this->histService->getHist($startDate);

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
