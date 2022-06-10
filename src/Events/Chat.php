<?php

namespace MichaelNabil230\LaravelChat\Events;

use MichaelNabil230\LaravelChat\Models\Chat as ChatModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Chat 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected ChatModel $message)
    {
    }
}
