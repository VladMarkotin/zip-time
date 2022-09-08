<?php

namespace App\Models;

use App\Models\SavedTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Savedlogs extends Model
{
    use HasFactory;
    protected $table = 'backlog';
    protected $fillable = ['user_id', 'saved_task_id', 'title', 'content'];


    public function savedTasks()
    {
        return $this -> belongsTo(SavedTask::class, 'saved_task_id', 'id');
    }


}




