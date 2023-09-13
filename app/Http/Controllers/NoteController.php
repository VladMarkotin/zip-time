<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SavedNotes;
use App\Models\Tasks;
use App\Models\SavedTask;
use Carbon\Carbon;

class NoteController extends Controller
{
    private $savedNotes = null;

    public function __construct(SavedNotes $savedNotes)
    {
        $this->savedNotes = $savedNotes;
    }

    public function getTodayNoteAmount()
    {
        $notes = SavedNotes::all()->count();
        die(var_dump($notes));
    }

    public function countTodayNoteAmount(array $data)
    {
        $savedTaskId = $this->getSavedTaskId($data);
        if ($savedTaskId) {

            return ( SavedNotes::select('id')
            ->where('saved_task_id', $savedTaskId)
            //->whereDate('created_at', Carbon::today())
            ->get()
            ->count()
            );
            //@file_put_contents('saved_id.tr', var_export($todayNotesAmount, true));
        }

        return 0;
    }

    private function getSavedTaskId(array $data)
    {
        $hash = Tasks::select('hash_code')->where('id', $data['id'])
            ->get()
            ->pluck('hash_code')
            ->toArray();
        if($hash[0]) {

                //get saved task id
                return (
                    $savedTaskId = SavedTask::select('id')->where([
                            ['hash_code', $hash[0]],
                            ['user_id', Auth::id()]
                        ])
                        ->get()
                        ->pluck('id')
                        ->toArray() 
                    );
                
        }

        return null;
    }
}
