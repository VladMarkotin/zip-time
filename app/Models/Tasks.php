<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $fillable = ['timetable_id', 'hash_code', 'task_name', 'type', 'priority', 'details', 'time', 'mark',
        'note'];
}
