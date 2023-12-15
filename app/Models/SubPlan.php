<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPlan extends Model
{
    use HasFactory;

    protected $table = 'subplans';
    protected $fillable = [
        'task_id',
        'saved_task_id',
        'main_task_id',
        'title',
        'text',
        'position',
        'weight',
        'checkpoint',
        'is_ready',
        'created_at_user_time',
        'done_at_user_time'
    ];
    protected $guarded = [];
}
