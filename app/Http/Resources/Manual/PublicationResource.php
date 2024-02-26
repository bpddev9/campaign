<?php

namespace App\Http\Resources\Manual;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'pub_id' => $this->id,
            'title' => $this->title,
            'publisher' => $this->publisher,
            'summary' => $this->summary,
        ];
    }
}
