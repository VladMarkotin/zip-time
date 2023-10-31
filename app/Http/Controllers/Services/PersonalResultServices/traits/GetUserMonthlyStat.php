<?php 

namespace App\Http\Controllers\Services\PersonalResultServices\traits;

use Illuminate\Support\Carbon;
use App\Models\TimetableModel;
use Illuminate\Support\Facades\Auth;

trait GetUserMonthlyStat 
{
    // public $daysInMonth = Carbon::now()->daysInMonth;

    public function getData() 
    {
        $daysInMonth = Carbon::now()->daysInMonth;
        $weekendsAndExtremeDays = GetUserMonthlyStat::quantityOfWeekendsAndExtremeDays();
        $successDays = GetUserMonthlyStat::quantityOfSuccessDays();

        return round ( ($weekendsAndExtremeDays + $successDays) / $daysInMonth * 100 , 2); 
        // return round ( ($weekendsAndExtremeDays + $successDays) / Carbon::now()->daysInMonth * 100 , 2); 
    }

    public function quantityofWeekendsAndExtremeDays()
    {
        return TimetableModel::where('day_status', '=', '0')
                                                ->orWhere('day_status', '=', '1')
                                                ->where('user_id', '=', Auth::user()->id)
                                                ->whereMonth('date', Carbon::now()->month)
                                                ->count();
    }

    public function quantityOfSuccessDays ()
    {
        return TimetableModel::   where('day_status', '=', '3')
                                ->where('user_id', '=', Auth::user()->id)
                                ->whereMonth('date', Carbon::now()->month)
                                ->count();
    }
}