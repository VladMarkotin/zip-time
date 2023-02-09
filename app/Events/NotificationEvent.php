<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $data;
    public $date;

  public function __construct($type, $data, $date)
  {
    $this->type = $type;
    $this->data  = $data;
    $this->date  = $date;
  }

  public function broadcastOn()
  {
      return ['ziptime'];
  }

  public function broadcastAs()
  {
      return 'notice';
  }
}
