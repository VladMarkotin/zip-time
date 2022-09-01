<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Notifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification_id;

    public $type;

    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($notification_id, $type, $data)
    {
        $this->notification_id = $notification_id;
        $this->type = $type;
        $this->data  = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['notifications'];
    }
}
