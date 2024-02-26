<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ApplicantEmploymentResource;

class EmploymentUserResource extends JsonResource
{

    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            "applied_job_id" => $this->id,
            'is_rejected' => (bool)$this->is_rejected,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone_no,
                'address' => optional($this->user->profile)->street_address,
                'city' => optional($this->user->profile)->city,
                'state' => optional($this->user->profile)->state,
                'zip' => optional($this->user->profile)->zip_code
            ],
            'job' => $this->when($request->segment(4) === 'applied-jobs', fn () => [
                'id' => optional($this->employment)->id,
                'position' => optional($this->employment)->position,
                'description' => optional($this->employment)->job_description,
            ]),
            'resume' => $this->resumeCheck($this->user),
            'answer' => $this->quest_ans ? true : false,
            'applied_on' => $this->created_at->format('jS M, Y'),
        ];
    }

    private function resumeCheck($user)
    {
        // $user = User::with('resume', 'workExperiences', 'qualifications', 'publications', 'certifications')->find($id);

        if (!is_null($user->resume)) {
            return true;
        } else {
            if ($user->workExperiences || $user->qualifications || $user->publications || $user->certifications || $user->skills) {
                return true;
            } else {
                return false;
            }
        }
    }
}
