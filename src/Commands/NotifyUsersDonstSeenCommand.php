<?php

namespace MichaelNabil230\LaravelChat\Commands;

use DateTime;
use Illuminate\Console\Command;
use MichaelNabil230\LaravelChat\Models\Message;
use MichaelNabil230\LaravelChat\Notifications\MessageSent;

class NotifyUsersDonstSeenCommand extends Command
{
    public $signature = 'laravel-chat:notify-users-donst-seen';

    public $description = 'Send notification to users that don\'t seen message';

    public function handle(): int
    {
        $date = new DateTime;
        $date->modify(config('chat.notifyUsersDonstSeen.time', '-1 hour'));
        $formattedDate = $date->format('Y-m-d H:i:s');

        $messages = Message::query()
            ->with('recipient')
            ->where('is_read', false)
            ->where('created_at', '>=', $formattedDate)
            ->get();

        foreach ($messages as $message) {
            $message->recipient->notify(new MessageSent($message));
        }

        $this->comment('All done');

        return self::SUCCESS;
    }
}
