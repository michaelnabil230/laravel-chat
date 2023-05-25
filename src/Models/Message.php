<?php

namespace MichaelNabil230\LaravelChat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'senderable_id',
        'senderable_type',
        'conversation_id',
        'read_at',
        'body',
        'attachments',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'collection',
        'settings' => 'collection',
        'read_at' => 'datetime',
    ];

    /**
     * Get the parent senderable model (user or nurse).
     */
    public function senderable()
    {
        return $this->morphTo();
    }

    /**
     * Get the conversation that owns the Message
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
