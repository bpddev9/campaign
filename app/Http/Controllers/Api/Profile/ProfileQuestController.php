<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileQuestController extends Controller
{
    public function index()
    {
        $questions = collect(json_decode(\File::get(storage_path('app/json-db/profileQ.json')), true));

        $profileQs = json_decode(optional(auth()->user()->profile)->questions, true);

        return response()->json([
            'data' => $this->formatResponse($questions, $profileQs)
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'answer' => [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $filtered = collect($value)->filter(fn ($v) => $v);

                    if (!$filtered->count()) {
                        $fail('You must answer least one profile question');
                    }
                }
            ]
        ]);

        $questions = collect(json_decode(\File::get(storage_path('app/json-db/profileQ.json')), true));
        
        $answers = collect($request->answer);
        
        $answers = $answers->map(function ($item, $key) {
            return ['question' => $key, 'answer' => $item];
        })->values();

        $request->user()->profile()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'questions' => $answers->toJson()
        ]);

        $profileQs = json_decode(optional(auth()->user()->profile)->questions, true);

        return response()->json([
            'data' => $this->formatResponse($questions, $profileQs)
        ]);
    }

    private function formatResponse($questions, $profileQs)
    {
        $profileQs = $questions->map(function ($item, $key) use($profileQs) {
            return [
                'q_no' => $key,
                'question' => $item,
                'answer' => (isset($profileQs[$key - 1]) && $profileQs[$key - 1]['question'] === $key) ? $profileQs[$key - 1]['answer'] : ''
            ];
        });

        return $profileQs->values();
    }
}
