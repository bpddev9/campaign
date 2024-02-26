<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResumeResource extends JsonResource
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
            'upload_id' => optional($this)->id,
            'file_name' => optional($this)->file_name,
            'mime_type' => optional($this)->mime_type,
            'file_path' => optional($this)->file_path !== null ? asset('/storage/' . $this->file_path) : null,
            'file_ext' => optional($this)->file_ext,
        ];
    }
}
