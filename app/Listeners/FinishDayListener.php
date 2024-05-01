<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Auth;
use App\Models\ChallengeModel;
use App\Http\Controllers\Services\Challenges\ChallengeService;
use App\Http\Controllers\Services\Challenges\CompleteNTasks;
use App\Repositories\EstimationRepository;
use App\Events\RewardEvent;

class FinishDayListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $challengeService = null;
    private $estimationRepository = null;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CompleteNTasks $challengeService,
                                EstimationRepository $eR
                                )
    {
        $this->challengeService = $challengeService;
        $this->estimationRepository = $eR;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $way = $event->getFinishWay();
        switch ($way) {
            case 1:
                $response = 'response';//$this->estimationRepository
                dispatch(function () use ($response) {
                    // Ваши действия с полученным ответом
                });
                break;
            default: return 0;
        }
        var_dump($way);
        die();
        RewardEvent::dispatch(['event_prefix' => ['f_vic', 'great_begin', 'keep_going'] ]);
        //$this->challengeService->doChallenge(['user_id' => Auth::id(), 'index' => $chIndex]);
    }
}
