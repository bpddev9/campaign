<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppliedUserResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone_no,
            'address' => optional($this->user->profile)->street_address,
            'city' => optional($this->user->profile)->city,
            'state' => optional($this->user->profile)->state,
            'zip' => optional($this->user->profile)->zip_code,
        ];
    }

    private function resumeCheck($user)
    {
        if (!is_null($user->resume)) {
            return true;
        } else {
            if ($user->workExperiences || $user->qualifications || $user->publications || $user->certifications) {
                return true;
            } else {
                return false;
            }
        }
    }
}
