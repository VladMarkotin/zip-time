<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preplan;
use Illuminate\Support\Facades\Auth;

class PreplanController extends Controller
{
    private $preplan = null;

    public function __construct(Preplan $preplan)
    {
        $this->preplan = $preplan;
    }

    public function addPreplan(Request $request)
    {
        $data = $request->json()->all();
        // dd($data["day_status"]);
        $preplanDate = $data["date"];
        $updatedData = [
            "user_id"      => null, 
            "date"         => null, 
            "jsoned_tasks" => null,
            "day_status"   => null,
        ];

        $updatedData["jsoned_tasks"] = json_encode($data["plan"]);
        $updatedData["date"] = $preplanDate;
        $updatedData["user_id"] = Auth::id();
        $updatedData["day_status"] = $data["day_status"];

        $allSet = true;

        foreach ($updatedData as $value) {
            if (!isset($value)) {
                $allSet = false;
                break; 
            }
        }

        if ($allSet) {
            $this->preplan::updateOrCreate(
                ["user_id" => $updatedData["user_id"], 'date' => $updatedData["date"]],
                $updatedData
            );

            return response()->json(["status" => 'success', "message" => "The preplan for $preplanDate was successfully created"]);
        }

        return response()->json(["status" => "error", "message" => "Error! Failed to create the preplan"]);
    }

    public function getPreplan(Request $request)
    {
        $date = $request->date;
        
        if (isset($date)) {
            $user_id = Auth::id();

            dd($user_id);
        }
    }
}
