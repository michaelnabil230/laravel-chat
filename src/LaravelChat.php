<?php

namespace MichaelNabil230\LaravelChat;

use Illuminate\Http\FileHelpers;
use Illuminate\Database\Eloquent\Model;
use MichaelNabil230\LaravelChat\Models\Message;
use MichaelNabil230\LaravelChat\Exceptions\MessageArgument;

class LaravelChat
{
    use FileHelpers;
    
    protected string $type = 'text';
    protected string $body;
    protected Model $sender;
    protected Model $recipient;

    public function __construct()
    {
    }

    public static function make()
    {
        return new static();
    }

    public function body(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function attachment(string $attachment): self
    {
        // TODO: Add files in storage
        $this->attachment = $attachment;

        return $this;
    }

    public function from(Model $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function to(Model $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Send message to recipient.
     *
     * @throws MessageArgument
     */
    public function send(): Message
    {
        if (!$this->sender) {
            throw MessageArgument::create('sender');
        }

        if (strlen($this->body) == 0) {
            throw MessageArgument::create('body');
        }

        if (!$this->recipient) {
            throw MessageArgument::create('receiver');
        }

        return new Message();
    }
}
