<?php
namespace App\Http\Livewire\LWServices;

use App\Models\SavedNotes;

class SavedNoteService
{
    public static function getNote()
    {
        $notes = SavedNotes::all();
        return $notes;
    }

    public static function selectAll()
    {
        $notes = SavedNotes::pluck('id');
        return $notes;
    }

    public static function clearNotes($selectedNotes)
    {
        SavedNotes::wherein('id', $selectedNotes)->delete();
        // dd($selectedNotes);
    }
}
