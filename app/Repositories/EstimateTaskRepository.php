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
use App\Repositories\DayPlanRepositories\GetPlanRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EstimateTaskRepository
{
    private $getPlanRepository = null;

    public function __construct(GetPlanRepository $getPlanRepository)
    {
        $this->getPlanRepository = $getPlanRepository;
    }
    /*Estimate task and update it dependencies if there is a hash_code. Better to upgrade logic of this method in future*/
    public function estimateTask(array $data)
    {
        $dataForTasks  =   [
            "id"         => $data['id'],
            "user_id"    => Auth::id(),
            "details"    => $data['details'],
            "mark"       => $data['mark'],
            "note"       => $data['note'],
            "updated_at" =>  Carbon::now(),
        ];
        $hash = Tasks::select('hash_code', 'type')->where('id', $data['id'])->get()->toArray();

        /*This condition for all tasks.*/
        if( ( ($hash[0]['type'] === 1) || ($hash[0]['type'] === 2) ) ){
            $dataForTasks['mark'] = $data['is_ready'];
            try{
                unset($dataForTasks['user_id']);

                Tasks::whereId($dataForTasks['id'])->update($dataForTasks);
                if($hash[0]['hash_code'] != '#'){ //if task is saved
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
                    $dataForLastTimeTableId = [
                        "date"    => Carbon::today(),
                        "id"      => Auth::id(),
                    ];

                    $dataForTasks["timetable_id"] =  $this->getPlanRepository->getLastTimetableId($dataForLastTimeTableId);
                    $this->complexUpdate($dataForTasks, $dataForNotes);
                }
            } catch (\Exception $e){
                Log::error('Error has happened with estimation of task : '. $e->getFile(). "\n". $e->getLine(). "\n". $e->getMessage());
            }


        } else if(($hash[0]['hash_code'] == '#') && ($hash[0]['type'] == 3 || $hash[0]['type'] == 4)){ //This condition for job with no hash code
            try{
                Tasks::whereId($data['id'])->update($dataForTasks);
            } catch (\Exception $e){
                Log::error('Error has happened: '. $e->getFile(). " ". $e->getLine(). " ");
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
            $dataForLastTimeTableId = [
                "date"    => Carbon::today(),
                "id" => Auth::id(),
            ];
            unset($dataForTasks['user_id']);
            $dataForTasks["timetable_id"] =  $this->getPlanRepository->getLastTimetableId($dataForLastTimeTableId);
            $this->complexUpdate($dataForTasks, $dataForNotes);
        }

        return true;
    }

    /*Complex update for saved task: update mark etc and insert new saved note*/
    private function complexUpdate(array $dataFotTasksTable, array $dataForNotesTable)
    {
        try{
            DB::transaction(function () use ($dataFotTasksTable, $dataForNotesTable) {
                //Firstly I have to update Task
                Tasks::whereId($dataFotTasksTable['id'])->update($dataFotTasksTable);
                //Secondly I have to create an array of data to update SavedTaskTable
                $dataForSavedTasks = [
                    "user_id"       => Auth::id(),
                    "saved_task_id" => $dataForNotesTable['saved_task_id'],
                    "details"       => $dataFotTasksTable['details'],
                ];
                //Then I update it
                DB::table('saved_tasks')->where([ ['id', '=', $dataForSavedTasks['saved_task_id']], ["user_id", '=', $dataForSavedTasks['user_id'] ] ] )
                    ->update(array(
                       'details' => $dataForSavedTasks['details']
                    ));
                //Finally I update (or insert) note in notes table

                $savedNote =  DB::table('notes')
                    ->select('id', 'note')
                    ->where('saved_task_id',   '=', $dataForNotesTable['saved_task_id'])
                    ->get()->toArray();

                $savedNote = (isset($savedNote[count($savedNote) - 1]->note))
                    ? $savedNote[count($savedNote) - 1]->note : null ;
                if( (!$savedNote && ($dataForNotesTable['note'] != ''))
                    || (($savedNote != trim($dataForNotesTable['note'])
                        && ($dataForNotesTable['note'] != '') )) ){
                    SavedNotes::insert($dataForNotesTable);
                }
            });
        } catch(\Exception $e){
            Log::error('Error has happened with complex update: '. $e->getFile(). " ". $e->getLine(). " ".$e->getMessage());
        }
    }
}
