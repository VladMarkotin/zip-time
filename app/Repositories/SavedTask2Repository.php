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
            ->select(DB::raw('hash_code'))
            ->where('user_id','=', $id)->get()->toArray();

        return ($savedTasks);
    }

    public function getSavedTaskByHashCode(array $params)
    {
        //array with object saved_task
        $savedTask = DB::table('saved_tasks')
            ->select('task_name', 'type', 'priority', 'details', 'time', 'note')
            ->where('user_id',   '=', $params['id'])
            ->where('hash_code', '=', $params['hash_code'])
            ->get()->toArray();

        return $savedTask;
    }

    public function saveNewHashCode(array $data)
    {
        $query = '';
        DB::table('saved_tasks')->insert($data);
    }
}
