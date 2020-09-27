<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected $table = "tasks";
    protected $timetable_id;
    protected $task_name;
    protected $details;
    protected $time;
    protected $mark;
    protected $note;
    protected $status;
}
