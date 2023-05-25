<?php

namespace MichaelNabil230\LaravelChat\Http\Resources\Message;

use MichaelNabil230\LaravelChat\Http\Resources\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MessageCollection extends ResourceCollection
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
            'data' => MessageResource::collection($this->collection),
            ...PaginationResource::make($this)->toArray($request),
        ];
    }
}
