<?php

namespace MichaelNabil230\LaravelChat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userable_one_id',
        'userable_one_type',
        'userable_two_id',
        'userable_two_type',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'collection',
    ];

    /**
     * Get the parent userableOne model (user or nurse).
     */
    public function userableOne()
    {
        return $this->morphTo();
    }

    /**
     * Get the parent userableTwo model (user or nurse).
     */
    public function userableTwo()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the messages for the Conversation
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the last message
     */
    public function lastMessage(): HasOne
    {
        return $this->messages()->one()->ofMany();
    }

    /**
     * Mark messages as read
     */
    public function unRead(string $model): void
    {
        $this
            ->messages()
            ->whereNull('read_at')
            ->where('senderable_type', $model)
            ->update(['read_at' => now()]);
    }
}
