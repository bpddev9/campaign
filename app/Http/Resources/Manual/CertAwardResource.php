<?php

namespace App\Http\Resources\Manual;

use Illuminate\Http\Resources\Json\JsonResource;

class CertAwardResource extends JsonResource
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
            'cert_id' => $this->id,
            'certificate' => $this->certificate,
            'award_org' => $this->award_org,
            'summary' => $this->summary,
            'start_year' => $this->start_year,
            'type' => $this->type
        ];
    }
}
