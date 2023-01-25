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
use Auth;


class AddNoteToSavedTask {

    private $notes = null;

    public function __construct(SavedNotes $notes)
    {
        $this->notes = $notes;
    }

    public function addSavedNote(array $params)
    {
        //Need hash_code and user_id, note
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
        $lastNoteId  = SavedNotes::where('saved_task_id', $savedTaskId)->max('id');//
        $lastNote    = SavedNotes::where('id', $lastNoteId)->get(['note'])->toArray();

        //it has to be a check of lastNote
        return $lastNote;

    }

    private function getSavedTaskId(array $params)
    {
        $savedTaskId = DB::table('saved_tasks')
            ->select(DB::raw('id'))
            ->where('hash_code', '=', $params['hash_code'])
            ->where('user_id', '=', Auth::id())->get(["id"])->toArray();
        if($savedTaskId){
            return $savedTaskId[0]->id;
        }

        return $savedTaskId;
    }
} 