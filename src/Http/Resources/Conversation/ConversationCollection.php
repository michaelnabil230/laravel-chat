<?php

namespace MichaelNabil230\LaravelChat\Http\Resources\Conversation;

use MichaelNabil230\LaravelChat\Http\Resources\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
