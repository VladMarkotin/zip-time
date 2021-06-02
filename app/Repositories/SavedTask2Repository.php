<?php
namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class SavedTask2Repository
{
    public function __construct()
    {
        //
    }

    public function getUserHashCodes($id)
    {
        $savedTasks = DB::table('saved_tasks')
            ->select(DB::raw('hash_code', 'task_name'))
            ->where('user_id','=', $id)->get()->toArray();

        return ($savedTasks);
    }
}
