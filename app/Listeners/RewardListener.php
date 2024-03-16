<?php

namespace App\Listeners;

use App\Events\RewardEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Auth;
use App\Models\ChallengeModel;
use App\Models\User;
use App\Http\Controllers\Services\Challenges\ChallengeService;
use DB;
use Illuminate\Support\Facades\Log;

class RewardListener
{
    private $challengeService = null;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ChallengeService $ch)
    {
        $this->challengeService = $ch;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RewardEvent  $event
     * @return void
     */
    public function handle(RewardEvent $event)
    {
        $chIndexes = DB::select("SELECT challenges.index FROM `challenges` WHERE challenges.id IN 
            (SELECT u_c.challenge_id FROM user_challenges u_c WHERE u_c.user_id = ". Auth::id() .")"
        );
        //->get()
        //->toArray();
        Log::info(var_export($chIndexes));
        $this->challengeService->doChallenge(['user_id' => Auth::id(), 'index' => 'test_reward']);
        $this->challengeService->doChallenge(['user_id' => Auth::id(), 'index' => 'test_reward2']);
    }
}
