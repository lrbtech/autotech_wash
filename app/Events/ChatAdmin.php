<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatAdmin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;

    public function __construct($message)
    {
      $this->message = $message;
    }

    public function broadcastOn()
    {
      //return ['my-channel'];
      return new Channel($this->message['channel_name']);
    }

    public function broadcastAs()
    {
      return 'chat-admin';
    }
}
