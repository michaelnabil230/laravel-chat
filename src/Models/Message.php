<?php

namespace MichaelNabil230\LaravelChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MichaelNabil230\LaravelChat\Observers\MessageObserver;
use MichaelNabil230\LaravelChat\Traits\Uuids;

class Message extends Model
{
    use Uuids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chat_id',
        'user_id',
        'type',
        'is_read',
        'body',
        'attachment',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        self::observe(MessageObserver::class);
    }

    /**
     * Get the chat that owns the Message
     *
     * @return BelongsTo
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(config('chat.messageModel', Chat::class));
    }
}
