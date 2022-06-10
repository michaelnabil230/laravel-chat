<?php

namespace MichaelNabil230\LaravelChat\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MichaelNabil230\LaravelChat\Models\Message as MessageModel;

class Message
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(protected MessageModel $message)
    {
    }
}
