<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\EmergencyService;
use App\Models\TimetableModel;
use App\Repositories\EstimationRepository;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    private $timetableModel       = null;
    private $emergencyService     = null;
    private $estimationRepository = null;

    public function __construct(TimetableModel $timetableModel,
                                EmergencyService $emergencyService,
                                EstimationRepository $estimationRepository)
    {
        $this->timetableModel   = $timetableModel;
        $this->emergencyService = $emergencyService;
        $this->estimationRepository = $estimationRepository;
    }

    public function index(Request $request)
    {
        $emergencyRequest = [
            "from"    => $request->get('from'),
            "to"      => $request->get('to'),
            "comment" => $request->get('comment')
        ];
        $checkedData = $this->emergencyService->check($emergencyRequest);
        $result = $this->estimationRepository->getEmergencyCall($checkedData);
        $response = [
            "from" => $result['from'],
            'to'   => $result['to'],
            'status' => "failed",
        ];
        if($result){
            $response['status']  = "success";
            $response['message'] = "Emergency mode has been successfully activated from $emergencyRequest[from] to $emergencyRequest[to].";

            return json_encode($response);
        }

        return json_encode($response);
    }

    public function getEmergencyModeDates(Request $request)
    {
        $today_date = $request->todayDate;
        $emergency_mode_dates = $this->emergencyService->getEmergencyModeDates($today_date);
        
        return response()->json(["emergency_mode_dates" => $emergency_mode_dates]);
    }
}
