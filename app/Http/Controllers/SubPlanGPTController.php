<?php

namespace App\Http\Controllers;

use App\Models\SubPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\GPTService\GPTService;
use App\Http\Controllers\Services\GPTService\traits\transformGptResponseTrait;
use Illuminate\Support\Facades\DB;
use Auth;

class SubPlanGPTController extends Controller
{
    use transformGptResponseTrait;

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
        $request = 'create plan for '.$request->get('request').'Return answer in bullet points';
        //test
        //  $testResponse = ' Determine the specific algorithms you want to study and understand their purpose and applications.\n","
        //  Start with basic algorithms such as sorting, searching, and graph algorithms.\n",
        //  " Familiarize yourself with the theoretical foundations of algorithms, including time and space complexity analysis.\n';
        // $response = explode('\n' , $testResponse);
        // $result = array();
        // foreach($response as $item)
        // {
        //     if(strlen($item) > 0)
        //     {
        //        array_push($result, $item);
        //     }
        // }
        // exit(json_encode($result));
         //end test
         $response = $this ->GPTService->chatGPT($request);
         $response = $response['choices'][0]['message']['content'];
         $response =  $this->transformData($response);
         echo json_encode($response);
       
    }

    public function createSubPlanViaGPT(Request $request)
    {
        if ($request->input('plan')) {
            //die(var_dump($request->input('plan'))); //array
            $hash = ($request->input('hash')) ?: null;
            $dataSet = [];
            $plan = $request->input('plan');
            if (count($plan) > 0) {
                $savedTaskId = DB::table('saved_tasks')
                ->select('id')
                ->where('user_id',   '=', Auth::id())
                ->where('hash_code', '=', $hash)
                //->union($savedDefaultTask)
                ->get()
                ->toArray();
                
                foreach ($plan as $i => $el) { //TODO validation of $request->input('plan')
                    $dataSet[] = [
                        'task_id'  => $request->input('taskId'),
                        'saved_task_id'    => $savedTaskId[0]->id, //todo later
                        'title'       => $el,
                        // 'created_at' => ,
                        // 'updated_at' => ,
                    ];
                }
                DB::table('subplans')->insert($dataSet);

            }

        }

        return response()->json([
            'data' => '',
            'status' => 0,
            'message' => 'Quipl couldn`t create subplan :('
        ]);//
    }
}
