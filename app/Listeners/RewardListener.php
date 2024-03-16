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
        $chIndex = $event->getEventPrefix();
        $this->challengeService->doChallenge(['user_id' => Auth::id(), 'index' => $chIndex]);
    }
}
