<?php

namespace MichaelNabil230\LaravelChat\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Messageable
{
    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(config('chat.models.message'), config('chat.tables.message_user'), 'user_id', 'message_id');
    }

    public function getUnreadMessagesCountAttribute(): int
    {
        return $this->loadCount(['messages as unread_messages_count' => function ($query) {
            $query
                ->where('sender_id', '!=', $this->getKey())
                ->where('is_read', false);
        }]);
    }
}
