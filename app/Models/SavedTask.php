<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedTask extends Model
{
    use HasFactory;

    protected $table = 'saved_tasks';
    protected $fillable = ['hash_code', 'task_name', 'time','type','details','status',
                             'created_at', 'updated_at'];
}
