<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileQuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = collect([
            '1' => "Where are you willing and unwilling to relocate?",
            '2' => "What are your preference regarding remote work?",
            '3' => "What do you value most in an organization's culture?",
            '4' => "What is your ideal work/life balance?",
            '5' => "What values are important for you to have in common with the candidate, office holder or cause for whom you'd like to work?",
            '6' => "What type of compensation wil you need to support your lifestyle and feel valued?",
            '7' => "What non-negotiables do you have? (i.e., what would make you automatically disinterested in a position)",
        ])->toArray();

        $profileQs = json_decode(optional($request->user()->profile)->questions, true);
        
        return view('account.questions.index', compact('questions', 'profileQs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'answer' => new \App\Rules\ProfileQuestion
        ]);

        $answers = collect($request->answer);

        $answers = $answers->map(function ($item, $key) {
            return ['question' => $key, 'answer' => $item];
        })->values();

        $request->user()->profile()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'questions' => $answers->toJson()
        ]);

        if ($request->user()->role === 'applicant') {
            return redirect()->route('applicant.view.profile')->with('success', 'Profile informations saved successfully');
        } else {
            return redirect()->route('campaign.view.profile')->with('success', 'Profile informations saved successfully');
        }
    }
}
