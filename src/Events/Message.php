<?php

namespace MichaelNabil230\LaravelChat\Events;

use Exception;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MichaelNabil230\LaravelChat\Http\Resources\Message\MessageResource;
use MichaelNabil230\LaravelChat\Models\Conversation;
use MichaelNabil230\LaravelChat\Models\Message as MessageModel;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        protected Conversation $conversation,
        protected MessageModel $message,
    ) {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $type = $this->getChannelName();

        return [
            new PrivateChannel("conversation.{$type}.{$this->conversation->id}"),
        ];
    }

    /**
     * The model event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message';
    }

    /**
     * Get the data to broadcast for the model.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'message' => MessageResource::make($this->message),
        ];
    }

    /**
     * The model event's broadcast name.
     *
     * @return \Exception|string
     */
    private function getChannelName(): ?string
    {
        return match ($this->message->senderable_type) {
            User::class => 'user',
            Nurse::class => 'nurse',
            default => throw new Exception("This type of sender {$this->message->senderable_type} is not found"),
        };
    }
}
