<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\SavedNotes;
use App\Models\Tasks;
use App\Models\SavedTask;
use Carbon\Carbon;
use Exception;
use App\Http\Controllers\Services\NotesService;

class NoteController extends Controller
{
    private $savedNotes   = null;
    private $notesService = null;
    private $carbon       = null;

    public function __construct(
        SavedNotes   $savedNotes,
        NotesService $notesService,
        Carbon       $carbon
    )
    {
        $this->savedNotes   = $savedNotes;
        $this->notesService = $notesService;
        $this->carbon       = $carbon;
    }

    public function addNote(Request $request, $isReturnResponse = true)
    {
        $task_id       = $request->get('task_id');
        $note          = $request->get('note');
        $data          = ['id' => $task_id, 'note' => $note];
        $saved_task_id = $this->getSavedTaskId($data);
        
        $noteAfterValidation = $this->notesService->addNoteForSavedTask($data);
        if (!$noteAfterValidation) {
            $noteAfterValidation = $this->notesService->makeNoteValid($note);
        }

        $response = [
            'status' => null,
            'text'   => null,
        ];

        try {
            if (isset($saved_task_id)) {
                $savedNoteData = [
                    'saved_task_id' => $saved_task_id,
                    'note'          => $noteAfterValidation,
                    'created_at'    => $this->carbon::now(),
                    'updated_at'    => $this->carbon::now(),
                ];
    
                SavedNotes::create($savedNoteData);
            } else {
                $current_task = Tasks::find($task_id);
                $current_task->update(['note' => $noteAfterValidation]);
            }

            $response['status'] = 'success';
            $response['text']   = 'note was added successfully';
        } catch(Exception $error) {
            $response['status'] = 'error';
            $response['text']   = 'something has happened';
        } finally {//если этот метод дергается напрямую с клиента, то отдам туда json
            if ($isReturnResponse) {
                return ;
            } 
            $response['saved_task_id'] = $saved_task_id;
            return $response;
        }
 
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
        $notes = SavedNotes::select('id', 'note', 'created_at')
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

    public function destroy (Request $request)
    {
        $note_id = $request->get('note_id');

        $response = [
            'status'  => '',
            'message' => '',
        ];

        try {
            $current_note = $this->savedNotes::find($note_id);
            $current_note->delete();

            $response['status'] = 'success';
            $response['message'] = 'note has been removed';
        } catch (Exception $error) {
            $response['status'] = 'error';
            $response['message'] = 'something has happend';
        } finally {
            return response()->json($response);
        }
    }
}
