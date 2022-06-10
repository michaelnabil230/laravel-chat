<?php

namespace MichaelNabil230\LaravelChat\Events\Message;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use MichaelNabil230\LaravelChat\Events\Message as EventMessage;

class Read extends EventMessage implements ShouldBroadcastNow
{
    public function broadcastOn()
    {
        return new Channel('chats.' . $this->message->chat_id);
    }

    public function broadcastAs()
    {
        return 'message.read';
    }
}
