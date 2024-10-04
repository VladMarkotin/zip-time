<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preplan;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\GeneralHelpers\GeneralHelper;

class PreplanController extends Controller
{
    private $preplan        = null;
    private $generealHelper = null;

    public function __construct(Preplan       $preplan,
                                GeneralHelper $generalHelper
                                )
    {
        $this->preplan = $preplan;
        $this->generealHelper = $generalHelper;
    }

    public function index(Request $request) 
    {
        $selected_plan_date = $request->date;
        $pattern = '/^\d{4}-\d{2}-\d{2}$/';

        if (preg_match($pattern, $selected_plan_date)) {
            $user_today_date = $this->generealHelper->getUsetTodayDate()->toDateString();
            return view('plan', compact('selected_plan_date', 'user_today_date'));
        } 

        return abort(404);
    }

    public function addPreplan(Request $request)
    {
        $data = $request->json()->all();

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
        $areAnyTasks = count($data["plan"]);

        foreach ([$updatedData["date"], $updatedData["user_id"], $updatedData["day_status"]] as $value) {
            if (!isset($value)) {
                $allSet = false;
                break; 
            }
        }

        if ($allSet) {
            if ($areAnyTasks) {
                $this->preplan::updateOrCreate(
                    ["user_id" => $updatedData["user_id"], 'date' => $updatedData["date"]],
                    $updatedData
                );
    
                return response()->json(["status" => 'success', "message" => "The preplan for $preplanDate was successfully created"]);
            }

            $preplan = $this->getPreplan(["user_id" => $updatedData["user_id"], "date" => $updatedData["date"]]);
            
            if (count($preplan)) {
                $preplan_id = $preplan["id"];
                
                $this->preplan::destroy($preplan_id);

                return response()->json(["status" => 'success', "message" => "The preplan for $preplanDate was successfully deleted"]);
            }
        }

        return response()->json(["status" => "error", "message" => "Error! Failed to create the preplan"]);
    }

    public function getPreplanData(Request $request)
    {
        $date = $request->date;

        $day_status_map = [
            1 => 'Weekend',
            2 => 'Work Day',
        ];

        $response = [
            "transformed_day_status" => $day_status_map[2],
            'tasks'                  => [],
        ];
        
        if (isset($date)) {
            $user_id = Auth::id();

            // $preplanData = $this->preplan::where('user_id', $user_id)->where('date', $date)->get()->toArray();
            $preplanData = $this->getPreplan(["user_id" => $user_id, 'date' => $date]);

            if (count($preplanData)) {
                
                $day_status = $preplanData['day_status'];
                $transformed_day_status = $day_status_map[$day_status];
                
                $response['tasks'] = json_decode($preplanData['jsoned_tasks']);
                $response["transformed_day_status"] = $transformed_day_status;
                
            }
        }

        return $response;
    }

    private function getPreplan(array $data)
    {
        $preplan = $this->preplan::where('user_id', $data["user_id"])->where('date', $data["date"])->get()->toArray();

        return count($preplan) ? $preplan[0] : [];
    }
}
