<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CompleteTaskEvent;
use App\Events\RewardEvent;
use Auth;
use App\Http\Controllers\Services\Challenges\ChallengeService;

class CompleteTaskListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(CompleteTaskEvent $event)
    {
        $this->challengeService->doChallenge(['user_id' => Auth::id(), 'index' => 'estimate_task']);
    }
}
