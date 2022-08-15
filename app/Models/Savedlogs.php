<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Savedlogs extends Model
{
    use HasFactory;
    protected $table = 'backlog';
    protected $fillable = ['user_id', 'saved_task_id', 'title', 'content'];
}




