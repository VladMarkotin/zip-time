<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableModel extends Model
{
    use HasFactory;

    protected $table    = "timetables";
    protected $fillable = ["day_status", "time_of_day_plan", "final_estimation", "own_estimation", "comment",
        "for_tomorrow", "created_at", "updated_at"
    ];
}
