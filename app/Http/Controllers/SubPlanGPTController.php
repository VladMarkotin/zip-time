<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubPlan;

class SubPlanGPTController extends Controller
{
    private $response = null;

    public function makeRequestToGPT(Request $request)
    {
        /**
         * Здесь нужно обращаться к chatGPT API и получать ответ
         */
        die(var_dump($request->get('request')));
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
