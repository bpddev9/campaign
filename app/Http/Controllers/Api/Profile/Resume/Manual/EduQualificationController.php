<?php

namespace App\Http\Controllers\Api\Profile\Resume\Manual;

use Illuminate\Http\Request;
use App\Models\Qualification;
use App\Http\Controllers\Controller;
use App\Http\Resources\Manual\QualificationResource;

class EduQualificationController extends Controller
{
    public function index(Request $request)
    {
        $qualifications = $request->user()->qualifications()->get();
        return QualificationResource::collection($qualifications);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'institute_name' => ['required', 'string'],
            'degree' => ['required', 'string'],
            'start_year' => ['required', 'numeric'],
            'end_year' => ['required', 'numeric', 'gte:start_year'],
            'q_id' => ['nullable', 'numeric']
        ]);

        $qualification = $request->user()->qualifications()->updateOrCreate([
            'id' => $request->q_id,
        ],[
            'institute_name' => $request->input('institute_name'),
            'degree' => $request->input('degree'),
            'start_year' => $request->input('start_year'),
            'end_year' => $request->input('end_year'),
        ]);

        return new QualificationResource($qualification);
    }

    public function destroy(Qualification $qualification)
    {
        $qualification->delete();
        return response()->json(null, 200);
    }
}
