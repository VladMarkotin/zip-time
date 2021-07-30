<?php

namespace App\Repositories\DayPlanRepository;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\DayPlanModel;

class CreateDayPlanRepository
{
    private $model;

    public function __construct(DayPlanModel $dayPlanModel)
    {
        $this->model = $dayPlanModel;
    }

    public function createDayPlan(array $data)
    {
        $dataForDayPlanCreation["user_id"]          = Auth::id();
        $dataForDayPlanCreation["date"]             = Carbon::today();
        $dataForDayPlanCreation["day_status"]       = $this->getNumValuesOfStrValues($data[0]["value"]);//temporary variant. day_status has to be general!!! Now it would not working
        $dataForDayPlanCreation["final_estimation"] = 0;
        $dataForDayPlanCreation["own_estimation"]   = 0;
        $this->model->fill($dataForDayPlanCreation);
        $this->model->save();

    }

    private function getNumValuesOfStrValues($data)
    {
        switch($data){
            case 'Work Day'  : return 3;
            case 'Weekend'   : return 2;
            case 'Holiday'   : return 1;
            case 'Emergency' : return 0;
        }

        return 0;
    }
}
