<?php

namespace MichaelNabil230\LaravelChat\Http\Resources\Conversation;

use MichaelNabil230\LaravelChat\Http\Resources\Message\MessageResource;
use MichaelNabil230\LaravelChat\Http\Resources\SenderResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $relationship = auth('user-api')->check() ? 'nurse' : 'user';

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'nurse_id' => $this->nurse_id,
            'receiver' => SenderResource::make($this->$relationship),
            'appointment' => [
                'id' => $this->appointment->id,
                'status' => $this->appointment->status,
                'date' => $this->appointment->date,
                'time_from' => $this->appointment->time_from,
                'time_to' => $this->appointment->time_to,
            ],
            'last_message' => MessageResource::make($this->lastMessage),
        ];
    }
}
