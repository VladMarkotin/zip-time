<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 12.11.2021
 * Time: 15:19
 */
namespace App\Repositories;


use App\Models\Tasks;
use App\Models\SavedNotes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstimateTaskRepository
{
    /*Estimate task and update it dependencies if there is a hash_code  */
    public function estimateTask(array $data)
    {
         //die(var_dump($data));
        $dataForTasks  =   [
            "id"       => $data['id'],
            "details"  => $data['details'],
            "mark"     => $data['mark'],
            "note"     => $data['note'],
        ];
        $hash = Tasks::select('hash_code')->where('id', $data['id'])->get()->toArray();
        if(!$hash){
            Tasks::whereId($data['id'])->update($dataForTasks);
        }else{
            $savedTaskId =  DB::table('saved_tasks')
                ->select('id')
                ->where('user_id',   '=', Auth::id())
                ->where('hash_code', '=', $hash)
                ->get()->toArray();
            $savedTaskId = $savedTaskId[0]->id;
            $dataForNotes = [
                'saved_task_id' => $savedTaskId,
                'note'          => $data['note']
            ];
            $this->complexUpdate($dataForTasks, $dataForNotes);
        }
        //$dataForTasks['hash']
        die(var_dump($hash[0]["hash_code"]));
    }

    private function complexUpdate(array $dataFotTasksTable, array $dataForNotesTable)
    {
        //die(var_dump($dataForNotesTable));
        try{
            DB::transaction(function () use ($dataFotTasksTable, $dataForNotesTable) {
                Tasks::whereId($dataFotTasksTable['id'])->update($dataFotTasksTable);

                $savedNote =  DB::table('notes')
                    ->select('id')
                    ->where('saved_task_id',   '=', $dataForNotesTable['saved_task_id'])
                    ->get()->toArray();
                $savedNote = (isset($savedNote[0]->id)) ? $savedNote[0]->id : null ;
                if($savedNote){
                    //die(var_dump($dataForNotesTable));
                    SavedNotes::where('saved_task_id', $dataForNotesTable['saved_task_id'])->update($dataForNotesTable);
                }else{
                    SavedNotes::insert($dataForNotesTable);
                }
            });
            /*end test*/
        } catch(\Exception $e){
            var_dump($e->getLine(). " : ". $e->getMessage());
        }
    }
} 