<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\ChallengeModel;

/**
 * dispatch when user or system trying to close day plans
 * 1 - manual way to close
 * 0 - automatical (cron) way to close
 */
class FinishDayEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $challengeModel = null;
    public $wayToCloseDay = 1;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        //$this->challengeModel = $data;
        $this->wayToCloseDay = $data['finish_way'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getFinishWay()
    {
        return $this->wayToCloseDay;
    }
}
