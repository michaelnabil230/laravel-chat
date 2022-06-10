<?php

namespace MichaelNabil230\LaravelChat\Observers;

use Illuminate\Support\Facades\Storage;
use MichaelNabil230\LaravelChat\Events\Message\Created;
use MichaelNabil230\LaravelChat\Events\Message\Deleted;
use MichaelNabil230\LaravelChat\Events\Message\Read;
use MichaelNabil230\LaravelChat\Events\Message\Updated;
use MichaelNabil230\LaravelChat\Models\Message;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     *
     * @param  Message  $message
     * @return void
     */
    public function created(Message  $message)
    {
        Created::dispatch($message);
    }

    /**
     * Handle the Message "updated" event.
     *
     * @param  Message  $message
     * @return void
     */
    public function updated(Message $message)
    {
        if ($message->isDirty('is_read')) {
            Read::dispatch($message);
        }

        if ($message->isDirty('message')) {
            Updated::dispatch($message);
        }
    }

    /**
     * Handle the Message "deleting" event.
     *
     * @param  Message  $message
     * @return void
     */
    public function deleting(Message $message)
    {
        if ($message->from_id == auth()->getKey()()) {
            if (! is_null($message->attachment)) {
                if (Storage::exists($message->attachment)) {
                    Storage::delete($message->attachment);
                }
            }
        }
    }

    /**
     * Handle the Message "deleted" event.
     *
     * @param  Message  $message
     * @return void
     */
    public function deleted(Message $message)
    {
        Deleted::dispatch($message);
    }
}
