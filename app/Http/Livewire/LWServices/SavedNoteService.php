<?php
namespace App\Http\Livewire\LWServices;

use App\Models\SavedNotes;

class SavedNoteService
{

    public static function getNote($id)
    {

        $notes = SavedNotes::where('saved_task_id', $id)
        ->orderBy('created_at', 'DESC')
            ->get();
            sleep(0);
        return $notes;
    }

    public static function selectAll($id)
    {
        $notes = SavedNotes::where('saved_task_id', $id)->pluck('id')->toArray();
        return $notes;

    }
    
    public static function clearNotes($selectedNotes)
    {
        //dd(gettype($selectedNotes));
        if($selectedNotes !== null)
        {
             SavedNotes::wherein('id', $selectedNotes)->delete();
        }else{
            return;
        }
        $selectedNotes = [];
    }
}
