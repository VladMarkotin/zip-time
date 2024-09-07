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
        $saved_task_id = $this->getSavedTaskId($params);
        SavedNotes::where('task_id', $params['task_id'])->update(['saved_task_id' => $saved_task_id]);
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