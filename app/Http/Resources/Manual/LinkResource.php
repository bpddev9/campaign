<?php

namespace App\Http\Resources\Manual;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
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
            'id' => $this->id,
            'title' => \Str::title($this->link_title),
            'url' => $this->link_url,
            'posted_on' => $this->created_at->format('l j M, Y')
        ];
    }
}
