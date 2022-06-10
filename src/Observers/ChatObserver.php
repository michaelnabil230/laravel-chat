<?php

namespace MichaelNabil230\LaravelChat\Observers;

use MichaelNabil230\LaravelChat\Events\Chat\Created;
use MichaelNabil230\LaravelChat\Events\Chat\Deleted;
use MichaelNabil230\LaravelChat\Models\Chat;

class ChatObserver
{
    /**
     * Handle the Chat "created" event.
     *
     * @param  \MichaelNabil230\LaravelChat\Models\Chat  $chat
     * @return void
     */
    public function created(Chat $chat)
    {
        Created::dispatch($chat);
    }

    /**
     * Handle the Chat "updated" event.
     *
     * @param  \MichaelNabil230\LaravelChat\Models\Chat  $chat
     * @return void
     */
    public function updated(Chat $chat)
    {
        if ($chat->deleted_from_sender && $chat->deleted_from_receiver) {
            $chat->delete();
        }
    }

    /**
     * Handle the Chat "deleted" event.
     *
     * @param  \MichaelNabil230\LaravelChat\Models\Chat  $chat
     * @return void
     */
    public function deleted(Chat $chat)
    {
        Deleted::dispatch($chat);
    }
}
