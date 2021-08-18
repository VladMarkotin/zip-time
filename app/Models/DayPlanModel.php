<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayPlanModel extends Model
{
    use HasFactory;

    protected $table = 'timetables';
    protected $fillable = ['user_id', 'date', 'day_status', 'final_estimation', 'own_estimation', 'created_at', 'updated_at'];
}
