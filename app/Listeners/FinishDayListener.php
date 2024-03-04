<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Auth;
use App\Models\ChallengeModel;
use App\Http\Controllers\Services\Challenges\ChallengeService;
use App\Http\Controllers\Services\Challenges\CompleteNTasks;

class FinishDayListener
{
    private $challengeService = null;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CompleteNTasks $challengeService)
    {
        $this->challengeService = $challengeService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $query = "SELECT COUNT(tasks.id) q FROM `tasks` JOIN timetables ON tasks.timetable_id = timetables.id 
            JOIN users ON timetables.user_id = ".Auth::id()." 
               WHERE tasks.mark <> -1";
        $terms = ChallengeModel::select('terms')->where('index', 'estimate_task')->get()->toArray()[0]['terms'];
        $chId = ChallengeModel::select('id')->where('index', 'estimate_task')->get()->toArray()[0]['id'];
        $result = $this->challengeService->doChallenge([
            'index' => 'estimate_task',
            'query' => $query,
            'terms' => json_decode($terms),
            'ch_id' => $chId,
        ]);
        //die(var_dump($result)); //OK
    }
}
