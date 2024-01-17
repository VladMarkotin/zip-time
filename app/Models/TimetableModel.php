<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimetableModel extends Model
{
    use HasFactory;

    protected $table    = "timetables";
    protected $fillable = ["day_status", "time_of_day_plan", "final_estimation", "own_estimation", "comment",
        "for_tomorrow", "created_at", "updated_at"
    ];


    public function isWeekendTaken()
    {
        return self::where('date', Carbon::today())
        ->where('user_id', Auth::id())
        ->where('day_status',1)
        ->where('own_estimation','=', 0)
        ->first();
    }

    public function isDayPlanCompleted()
    {
        return self::where('date', Carbon::today())
        ->where('user_id', Auth::id())
        ->where('day_status','=', 3)
        ->orWhere('day_status','=', 1)
        ->orWhere('day_status','=', 0)
        ->first();
    }
}
