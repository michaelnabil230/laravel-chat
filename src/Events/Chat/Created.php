<?php

namespace MichaelNabil230\LaravelChat\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use MichaelNabil230\LaravelChat\Events\Chat as EventChat;

class Created extends EventChat implements ShouldBroadcastNow
{
    public function broadcastOn()
    {
        return new Channel('chats.' . $this->chat->getKey());
    }

    public function broadcastAs()
    {
        return 'chat.created';
    }
}
