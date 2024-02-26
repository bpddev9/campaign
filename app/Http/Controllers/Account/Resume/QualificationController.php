<?php

namespace App\Http\Controllers\Account\Resume;

use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Http\Controllers\Controller;

class QualificationController extends Controller
{
    public function index()
    {
        $qualifications = auth()->user()->qualifications()->get();

        return response()->json([
            'data' => $qualifications
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'institute_name' => ['required', 'string'],
            'degree' => ['required', 'string'],
            'start_year' => ['required', 'numeric'],
            'end_year' => ['required', 'numeric', 'gte:start_year'],
            'qualification_id' => ['nullable', 'numeric']
        ]);

        $qualification = $request->user()->qualifications()->updateOrCreate([
            'id' => $request->qualification_id,
        ],[
            'institute_name' => $request->input('institute_name'),
            'degree' => $request->input('degree'),
            'start_year' => $request->input('start_year'),
            'end_year' => $request->input('end_year'),
        ]);

        return response()->json([
            'data' => [
                'id' => $qualification->id,
                'degree' => $qualification->degree,
                'institute_name' => $qualification->institute_name,
                'start_year' => $qualification->start_year,
                'end_year' => $qualification->end_year,
            ],
        ]);
    }

    public function destroy(Qualification $qualification)
    {
        $qualification->delete();
        return response()->json(null, 200);
    }
}
