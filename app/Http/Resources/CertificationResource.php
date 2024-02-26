<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CertificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        if ($this->type === 'certification') {
            return [
                'certificate' => $this->certificate,
                'organization' => $this->award_org,
                'summary' => $this->summary,
                'start_year' => $this->start_year
            ];
        }
        elseif ($this->type === 'award') {
            return [
                'award' => $this->certificate,
                'organization' => $this->award_org,
                'summary' => $this->summary,
                'start_year' => $this->start_year
            ];
        }


    }
}
