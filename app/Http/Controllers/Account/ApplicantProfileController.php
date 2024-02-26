<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicantProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user()->load([
            'profile',
            'workExperiences',
            'certifications',
            'qualifications',
            'publications',
            'resume'
        ]);

        $questions = collect([
            '1' => "Where are you willing and unwilling to relocate?",
            '2' => "What are your preference regarding remote work?",
            '3' => "What do you value most in an organization's culture?",
            '4' => "What is your ideal work/life balance?",
            '5' => "What values are important for you to have in common with the candidate, office holder or cause for whom you'd like to work?",
            '6' => "What type of compensation wil you need to support your lifestyle and feel valued?",
            '7' => "What non-negotiables do you have? (i.e., what would make you automatically disinterested in a position)",
        ])->toArray();

        $profileQs = json_decode(optional($user->profile)->questions, true);

        $certifications = $request->user()->certifications()->where('type', 'certification')->get();
        $awards = $request->user()->certifications()->where('type', 'award')->get();
        
        return view('account.profile.applicant.index', compact('user', 'questions', 'profileQs', 'certifications', 'awards'));
    }
}
