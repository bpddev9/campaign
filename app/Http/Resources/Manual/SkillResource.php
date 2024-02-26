<?php

namespace App\Http\Resources\Manual;

use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'skill_id' => $this->id,
            'skill_name' => json_decode($this->skill_name)
        ];
    }
}
