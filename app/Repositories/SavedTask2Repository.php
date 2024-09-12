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

    public function getUserHashCodes($id, $status = 1)
    {
        if ($status) {
            $savedTasks = DB::table('saved_tasks')
                ->select(DB::raw('hash_code'))
                ->where('user_id','=', $id)
                ->where('status', $status)
                ->get()->toArray();
        } else {
            $savedTasks = DB::table('saved_tasks')
                ->select(DB::raw('hash_code'))
                ->where('user_id','=', $id)
                ->get()->toArray();
        }

        return ($savedTasks);
    }

    /*get the most popular hashes based on next week`s day */
    public function getMostPopularHashesOnNextDay($id, $status = 1)
    {
        $query = "SELECT t1.hash_code,  COUNT(t1.id) num FROM tasks t1 JOIN timetables t2 ON t1.timetable_id = t2.id
        JOIN saved_tasks s ON (s.hash_code = t1.hash_code AND s.user_id = $id )
           WHERE t2.user_id=$id
          AND DAYOFWEEK(t2.date) = DAYOFWEEK(now() + interval 1 day)
          AND t1.hash_code <> '#'
          AND s.status=$status
         GROUP BY t1.hash_code
           order by t1.type DESC, t1.priority DESC, num DESC";
        $result = DB::select($query);
        
        return $result;
    }
    /* end */

    public function getSavedTaskByHashCode(array $params)
    {
        /*Must do it better (task`s types store in db)*/
        $handleTypeOfTaskFromDb = function ($type) {
            switch ($type) {
                case 4: return "required job";
                case 3: return "non required job";
                case 2: return "required task";
                case 1: return "task";
            }

            return $type;
        };
        $paramsForNotes = [
            'user_id'   => Auth::id(),
            'hash_code' => $params['hash_code']
        ];
        $lastNoteArray = $this->notesRepository->getLastNote($paramsForNotes);//возвращает последнюю заметку,но ее надо как-то + в savedTask
        
        $savedDefaultTask = DB::table('default_saved_tasks')
            ->select('hash_code','task_name', 'type', 'priority', 'details', 'time', 'note')
            ->where('hash_code', '=', $params['hash_code']);

        $savedTask = DB::table('saved_tasks')
            ->select('hash_code','task_name', 'type', 'priority', 'details', 'time', 'note')
            ->where('user_id',   '=', Auth::id())
            ->where('hash_code', '=', $params['hash_code'])
            ->union($savedDefaultTask)
            ->get()->toArray();
        /*Remove spechial chars here. Have to move it in another place (Service?)*/
        foreach ($savedTask as $k => &$v) {
            $v->task_name = htmlspecialchars_decode($v->task_name);
            $v->details = htmlspecialchars_decode($v->details);
            $v->type    = $handleTypeOfTaskFromDb($v->type);
        }
        /* end */
        if(count($lastNoteArray) > 0){
            $lastNote = $lastNoteArray[0]['note'];
            $savedTask[0]->note = htmlspecialchars_decode($lastNote);
        }
        
        return count($savedTask) ? $savedTask[0] : $savedTask;
    }

    public function saveNewHashCode(array $data)
    {
        DB::table('saved_tasks')->insert($data);
    }
}
