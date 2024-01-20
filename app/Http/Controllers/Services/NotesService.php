<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 15.08.2021
 * Time: 13:52
 */

namespace App\Http\Controllers\Services;


use App\Repositories\SavedTask2Repository;

/* Works with notes for saved tasks */
class NotesService
{
    private $savedTaskRepository = null;

     public function __construct(SavedTask2Repository $savedTask2Repository)
     {
         $this->savedTaskRepository = $savedTask2Repository;
     }

    public function addNoteForSavedTask(array $params)
    {
        //die(var_dump($params));
        $note = $params['note'];
        if($this->checkNote($note) ){
            $note = $this->cleanNote($note);
            if($note){
                return $note;
            }
        }

        return false;
    }

    private function checkNote($note)
    {
        if(strlen($note) < 255 && (strlen($note) > 0)){
            return $note;
        }

        return false;
    }

    private function cleanNote($note)
    {
        $note = strip_tags($note);

        return $note;
    }

    public function makeNoteValid($note)
    {
        //может прийти или null или большая строка
        if (isset($note)) {
            $note = htmlspecialchars($note);
            
            if(strlen($note) > 255){
                $diff = strlen($note) - 255;
                $note = substr($note, 0, -$diff);
            }
        }

        return $note;
    }
} 