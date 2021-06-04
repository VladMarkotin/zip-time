<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 29.05.2021
 * Time: 7:52
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\SavedTask2Repository;

class MainController
{
    private $savedTaskRepository = null;

    public function __construct(SavedTask2Repository $taskRepository )
    {
        $this->savedTaskRepository = $taskRepository;
    }

    public function addHashCode(Request $request)
    {
        dd($request->input('hash'));
    }

    public function getSavedTasks()
    {
        $id = Auth::id();
        $hashCodes = $this->savedTaskRepository->getUserHashCodes($id);

        return response()->json([
            'id' => $id,
            'hash_codes' => $hashCodes,
        ]);//
    }

    public function getSavedTaskByHashCode(Request $request)
    {
        $hash_code = $request->get('hash_code');
        $params = ['id' => '', 'hash_code' => ''];
        $finalResult = [];
        if($hash_code){
            $params['id'] = Auth::id();
            $params['hash_code'] = $hash_code;
            $savedTask = $this->savedTaskRepository->getSavedTaskByHashCode($params);
            foreach ($savedTask as $val){
                foreach ($val as $i => $v){
                    $finalResult[] = $val->$i;
                }
            }
        }

        return response()->json($finalResult);//
    }
} 