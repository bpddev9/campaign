<?php

namespace App\Http\Resources\Manual;

use Illuminate\Http\Resources\Json\JsonResource;

class QualificationResource extends JsonResource
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
            'q_id' => $this->id,
            'institute_name' => $this->institute_name,
            'degree' => $this->degree,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year
        ];
    }
}
