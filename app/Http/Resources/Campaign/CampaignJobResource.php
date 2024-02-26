<?php

namespace App\Http\Resources\Campaign;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignJobResource extends JsonResource
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
            'job_industry' => $this->jobTitle->industry->title,
            'job_title' => $this->jobTitle->position,
            'job_title_id' => $this->job_title_id,
            'location_type' => $this->location_type,
            'job_position' => $this->job_position,
            'job_description' => $this->job_description,
            'job_benefit' => $this->job_benefit,
            'job_type' => $this->job_type,
            'job_schedule' => $this->job_schedule,
            'no_of_people' => $this->no_of_people,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'pay_rate' => $this->pay_rate,
            'can_call' => (bool) $this->can_call,
            'can_post_resume' => (bool) $this->can_post_resume,
            'appl_quest' => collect(json_decode($this->appl_quest)),
            'created_at' => $this->created_at->format('m-d-Y'),
        ];
    }
}
