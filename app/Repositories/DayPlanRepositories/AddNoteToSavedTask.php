<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 15.08.2021
 * Time: 14:37
 */

namespace App\Repositories\DayPlanRepositories;


use App\Models\SavedNotes;
use Illuminate\Support\Facades\DB;

class AddNoteToSavedTask {

    private $notes = null;

    public function __construct(SavedNotes $notes)
    {
        $this->notes = $notes;
    }

    public function addSavedNote(array $params)
    {
        //die(var_dump($params));
        //Need hash_code and user_id
        $savedTask = [
            "hash_code" => $params['hash_code'],
            "user_id"   => $params['user_id']
        ];
        $savedTaskId = $this->getSavedTaskId($savedTask);
        $data = [
            'saved_task_id' => $savedTaskId,
            'note'          => $params['note']
        ];

        SavedNotes::insert($data);
    }

    public function getLastNote(array $params)
    {
        $savedTaskId = $this->getSavedTaskId($params);
        $lastNote = SavedNotes::where('saved_task_id', $savedTaskId)->get(['note'])->toArray();
        //it has to be a check of lastNote
        return $lastNote;

    }

    private function getSavedTaskId(array $params)
    {
        //die(var_dump($params));
        $savedTaskId = DB::table('saved_tasks')
            ->select(DB::raw('id'))
            ->where('hash_code', '=', $params['hash_code'])
            ->where('user_id', '=', $params['user_id'])->get(["id"])->toArray();

        return $savedTaskId[0]->id;
    }
} 