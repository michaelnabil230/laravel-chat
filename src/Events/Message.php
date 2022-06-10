<?php

namespace MichaelNabil230\LaravelChat\Events;

use MichaelNabil230\LaravelChat\Models\Message as MessageModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected MessageModel $message)
    {
    }
}
