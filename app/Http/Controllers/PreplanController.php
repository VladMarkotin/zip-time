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
        $preplanDate = $data["date"];
        $updatedData = [
            "user_id"      => null, 
            "date"         => null, 
            "jsoned_tasks" => null
        ];

        $updatedData["jsoned_tasks"] = json_encode($data["plan"]);
        $updatedData["date"] = $preplanDate;
        $updatedData["user_id"] = Auth::id();

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
}
