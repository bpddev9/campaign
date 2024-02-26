<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicantQuestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'question.*' => ['required', 'string', 'distinct']
        ]);

        $questions = collect($request->input('question'))->map(fn ($item, $key) => [
            'sl_no' => $key + 1,
            'quest' => $item
        ]);

        $request->user()->companyProfile()->update([
            'appl_quest' => $questions->toJson()
        ]);

        return redirect()->route('campaign.view.profile')->with('success', 'Applicant questions saved successfully');
    }
}
