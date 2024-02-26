<?php

namespace App\Http\Controllers\Api\Campaign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = collect(json_decode($request->user()->companyProfile->appl_quest));

        return response()->json([
            'data' => $questions->all()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'question.*' => ['required', 'string', 'distinct']
        ]);

        $questions = collect($request->input('question'))->map(fn ($item, $key) => [
            'sl_no' => $key + 1, 'quest' => $item
        ]);

        $request->user()->companyProfile()->update([
            'appl_quest' => $questions->toJson()
        ]);

        $questions = collect(json_decode($request->user()->companyProfile->appl_quest));

        return response()->json([
            'data' => $questions->all()
        ]);
    }
}
