<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultSavedTasks extends Model
{
    use HasFactory;

    protected $table = 'default_saved_tasks';
    protected $fillable = ['hash_code', 'task_name', 'type','priority','details','time',
                             'created_at', 'updated_at'];
}
