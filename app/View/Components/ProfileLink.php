<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProfileLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $link, $profileImage;

    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (auth()->user()->role === 'applicant') {
            $this->link = route('applicant.view.profile');
            $this->profileImage = optional(auth()->user()->profile)->profile_pic;
        } else {
            $this->link = route('campaign.view.profile');
            $this->profileImage = optional(auth()->user()->companyProfile)->logo_img;
        }

        return view('components.profile-link');
    }
}
