<?php

namespace MichaelNabil230\LaravelChat\Http\Resources\Conversation;

use Illuminate\Http\Resources\Json\ResourceCollection;
use MichaelNabil230\LaravelChat\Http\Resources\PaginationResource;

class ConversationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => ConversationResource::collection($this->collection),
            ...PaginationResource::make($this)->toArray($request),
        ];
    }
}
