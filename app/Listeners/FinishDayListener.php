<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Auth;
use App\Models\ChallengeModel;
use App\Http\Controllers\Services\Challenges\ChallengeService;

class FinishDayListener
{
    private $challengeService = null;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ChallengeService $challengeService)
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

        $result = $this->challengeService->doChallenge([
            'index' => 'estimate_task',
            'query' => $query,
        ]);
        //die(var_dump($result)); //OK
    }
}
