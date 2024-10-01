<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
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
            'api' => $this->api,
            'description' => $this->description,
            'link' => $this->link,
            'category' => [
                'id' => $this->category->id,
                'category' => $this->category->category,
            ],
        ];
    }
}
