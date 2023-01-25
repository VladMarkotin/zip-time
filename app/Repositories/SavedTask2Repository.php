<?php
namespace App\Repositories;


use Illuminate\Support\Facades\DB;
use App\Repositories\DayPlanRepositories\AddNoteToSavedTask;
use Auth;

class SavedTask2Repository
{
    private $notesRepository = null;

    public function __construct(AddNoteToSavedTask $addNoteToSavedTask)
    {
        $this->notesRepository = $addNoteToSavedTask;
    }

    public function getUserHashCodes($id)
    {
        $savedTasks = DB::table('saved_tasks')
            ->select(DB::raw('hash_code'))
            ->where('user_id','=', $id)
            ->where('status', 1)
            ->get()->toArray();

        return ($savedTasks);
    }

    public function getSavedTaskByHashCode(array $params)
    {
        $paramsForNotes = [
            'user_id'   => Auth::id(),
            'hash_code' => $params['hash_code']
        ];
        $lastNoteArray = $this->notesRepository->getLastNote($paramsForNotes);//возвращает последнюю заметку,но ее надо как-то + в savedTask
        
        $savedTask = DB::table('saved_tasks')
            ->select('hash_code','task_name', 'type', 'priority', 'details', 'time', 'note')
            ->where('user_id',   '=', Auth::id())
            ->where('hash_code', '=', $params['hash_code'])
            ->get()->toArray();
        if(count($lastNoteArray) > 0){
            $lastNote = $lastNoteArray[0]['note'];
            $savedTask[0]->note = $lastNote;
        }

        return $savedTask;
    }

    public function saveNewHashCode(array $data)
    {
        DB::table('saved_tasks')->insert($data);
    }
}
