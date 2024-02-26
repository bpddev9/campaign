<?php

namespace App\Http\Resources\Manual;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkExperienceResource extends JsonResource
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
            'exp_id' => $this->id,
            'title' => $this->title,
            'companyName' => $this->company_name,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'description' => $this->description,
            'isCurrentlyWorking' => (bool) $this->currently_working,
        ];
    }
}
