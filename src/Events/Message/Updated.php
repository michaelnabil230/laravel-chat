<?php

namespace MichaelNabil230\LaravelChat\Events\Message;

use MichaelNabil230\LaravelChat\Events\Message as EventMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class Updated extends EventMessage implements ShouldBroadcastNow
{
    public function broadcastOn()
    {
        return new Channel('chats.' . $this->message->chat_id);
    }

    public function broadcastAs()
    {
        return 'message.updated';
    }
}
