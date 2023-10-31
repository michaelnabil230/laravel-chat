<?php

namespace MichaelNabil230\LaravelChat\Http\Resources\Message;

use Illuminate\Http\Resources\Json\JsonResource;
use MichaelNabil230\LaravelChat\Http\Resources\SenderResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'im_sender' => $this->senderable->is(auth()->user()),
            'sender' => SenderResource::make($this->senderable)->additional([
                'type' => str($this->senderable_type)->classBasename()->camel(),
            ]),
            'body' => $this->body,
            'type' => $this->type,
            'read_at' => $this->read_at?->diffForHumans(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
