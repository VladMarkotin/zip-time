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
    /*Estimate task and update it dependencies if there is a hash_code. Better to upgrade logic of this method in future*/
    public function estimateTask(array $data)
    {
        $dataForTasks  =   [
            "id"       => $data['id'],
            "details"  => $data['details'],
            "mark"     => $data['mark'],
            "note"     => $data['note'],
        ];
        $hash = Tasks::select('hash_code', 'type')->where('id', $data['id'])->get()->toArray();

        /*This condition for usual task. Could be extended for required task*/
        if( ($hash[0]['type'] === 1) ){
            $dataForTasks['mark'] = $data['is_ready'];
            try{
                Tasks::whereId($data['id'])->update($dataForTasks);
            } catch (\Exception $e){
                var_dump($e->getLine(). " : ". $e->getMessage());
            }
        } else if($hash[0]['type'] === 2){
            $dataForTasks['mark'] = $data['is_ready'];
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
        } else if($hash[0]['hash_code'] == '#'){ //This condition for job with no hash code
            try{
                Tasks::whereId($data['id'])->update($dataForTasks);
            } catch (\Exception $e){
                var_dump($e->getLine(). " : ". $e->getMessage());
            }
        } else{ //This one is for job with hash_code
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

        return true;
    }

    /*Complex update for saved task: update mark etc and insert new saved note*/
    private function complexUpdate(array $dataFotTasksTable, array $dataForNotesTable)
    {
        try{
            DB::transaction(function () use ($dataFotTasksTable, $dataForNotesTable) {
                Tasks::whereId($dataFotTasksTable['id'])->update($dataFotTasksTable);

                $savedNote =  DB::table('notes')
                    ->select('id', 'note')
                    ->where('saved_task_id',   '=', $dataForNotesTable['saved_task_id'])
                    ->get()->toArray();
                $savedNote = (isset($savedNote[0]->note)) ? $savedNote[0]->note : null ;
                if($savedNote && ($savedNote != trim($dataForNotesTable['note']) )){
                    SavedNotes::insert($dataForNotesTable);
                }
            });
            /*end test*/
        } catch(\Exception $e){
            var_dump($e->getLine(). " : ". $e->getMessage());
        }
    }
} 