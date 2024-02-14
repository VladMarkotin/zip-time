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


class CompleteTaskEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    private $challengeModel = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChallengeModel $challengeModel)
    {
        $this->challengeModel = $challengeModel;
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

    public function broadcastAs()
    {
        return 'updateTask';
    }

    public function broadcastWith($data)
    {
        die(var_dump($data));
    }
}
