<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'address' => optional($this->profile)->street_address,
            'city' => optional($this->profile)->city,
            'state' => optional($this->profile)->state,
            'zip_code' => optional($this->profile)->zip_code,
            'political_group' => Str::lower($this->political_group),
            'phone_no' => $this->phone_no,
            'profile_pic' => $this->getProfileImage($this->profile),
            'resume_file_name' => optional($this->resume)->file_name
        ];
    }

    private function getProfileImage($profile): ?string
    {
        if ($profile && !is_null($profile->profile_pic)) {
            return asset('/storage/' . $profile->profile_pic);
        } else {
            return null;
        }
    }
}
