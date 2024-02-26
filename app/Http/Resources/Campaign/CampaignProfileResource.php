<?php

namespace App\Http\Resources\Campaign;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignProfileResource extends JsonResource
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
            'profile_id' => optional($this->companyProfile)->id,
            'company_name' => optional($this->companyProfile)->company_name,
            'company_email' => optional($this->companyProfile)->company_email,
            'contact_person' => optional($this->companyProfile)->contact_person,
            'street_address' => optional($this->companyProfile)->street_address,
            'city' => optional($this->companyProfile)->city,
            'state' => optional($this->companyProfile)->state,
            'zip_code' => optional($this->companyProfile)->zip_code,
            'political_group' => $this->political_group, 
            'company_logo' => (isset($this->companyProfile) && !is_null($this->companyProfile->logo_img)) ? asset('storage/' . $this->companyProfile->logo_img) : null
        ];
    }
}
