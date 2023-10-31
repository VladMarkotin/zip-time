<?php

namespace App\Http\Controllers;

use App\Models\SubPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\GPTService\GPTService;

class SubPlanGPTController extends Controller
{
    private $response = null;
    private $GPTService;

    public function __construct(SubPlan $subPlan, GPTService $GPTService)
    {
        $this->GPTService  = $GPTService;
    }


    public function makeRequestToGPT(Request $request)
    {
        /**
         * Здесь нужно обращаться к chatGPT API и получать ответ
         */
         $request = 'create plan for '.$request->get('request');
         $response = $this ->GPTService->chatGPT($request);
        die(var_dump( $response));
    }

    public function createSubPlanViaGPT(Request $request)
    {
        die(var_dump($request->all()));
        if ($this->response) {
            //Work with SubPlanModel
        }

        return response()->json([
            'data' => '',
            'status' => 0,
            'message' => 'Quipl couldn`t create subplan :('
        ]);//
    }
}
