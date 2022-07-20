<?php
namespace App\Http\Livewire\LWServices;

use App\Models\SavedNotes;


class SavedNoteService
{

    public static function getNote($id)
    {
        $notes = SavedNotes::where('saved_task_id', $id)->get();
        return $notes;
    }

    public static function clearNotes($id)
    {
         SavedNotes::where('saved_task_id', $id)->first()->delete();
    }

}