<?php

namespace MichaelNabil230\LaravelChat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MichaelNabil230\LaravelChat\Traits\Uuids;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MichaelNabil230\LaravelChat\Observers\ChatObserver;

class Chat extends Model
{
    use Uuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'deleted_from_sender',
        'deleted_from_receiver',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        self::observe(ChatObserver::class);
    }

    /**
     * Get all of the messages for the Chat
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(config('chat.messageModel', Message::class));
    }

    /**
     * Get the lastMessage associated with the Chat
     *
     * @return HasOne
     */
    public function lastMessage(): HasOne
    {
        return $this->hasOne(config('chat.messageModel', Message::class))->ofMany();
    }
}
