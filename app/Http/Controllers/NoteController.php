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

    public function getSavedNotes(Request $request)
    {
        //get id of saved_task
        $savedTaskId = SavedTask::select('id')->where([['hash_code', $request->get('hash')], ['user_id', Auth::id()]])
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();

        if (!count($savedTaskId)) {
            return json_encode([]);
        }

        $savedTaskId = $savedTaskId[0]['id'];

        //get notes for saved Task
        $notes = SavedNotes::select('note', 'created_at')
        ->where('saved_task_id', $savedTaskId)
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();
        //die(var_dump($notes));
        return json_encode( $notes, JSON_UNESCAPED_UNICODE);
    }

    public function getTodayNoteAmount(Request $request)
    {
        $notesAmount = $this->countTodayNoteAmount($request->all());
        exit(json_encode(['amount' => $notesAmount]));
    }
    
    public function countTodayNoteAmount(array $data)
    {
        $savedTaskId = $this->getSavedTaskId($data);
        if ($savedTaskId) {
            
            $amount = (SavedNotes::select('id')
            ->where('saved_task_id', $savedTaskId)
            //->whereDate('created_at', Carbon::today())
            ->get()
            ->count());
            return $amount;
        }

        return 0;
    }

    private function getSavedTaskId(array $data)
    {
        $data['id'] = (!isset($data['id']) ) ?  $data['task_id'] : $data['id'];
        $hash = Tasks::select('hash_code')->where('id', $data['id'])
            ->get()
            ->pluck('hash_code')
            ->toArray();
        if(isset($hash[0])) {

                //get saved task id
                
            $savedTaskId = SavedTask::select('id')->where([
                            ['hash_code', $hash[0]],
                            ['user_id', Auth::id()]
                        ])
                        ->get()
                        ->pluck('id')
                        ->toArray();
        
            if (isset($savedTaskId[0])) {
                return $savedTaskId[0];
            }        
                
        }

        return null;
    }
}
