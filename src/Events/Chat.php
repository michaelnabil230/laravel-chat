<?php

namespace MichaelNabil230\LaravelChat\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MichaelNabil230\LaravelChat\Models\Chat as ChatModel;

class Chat
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(protected ChatModel $message)
    {
    }
}
