<?php

namespace App\Http\Controllers\Api\Profile\Resume\Manual;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WorkExperience;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\Manual\WorkExperienceResource;

class ExperienceController extends Controller
{
    public function index(Request $request)
    {
        $experiences = $request->user()->workExperiences()->latest()->get();
        return WorkExperienceResource::collection($experiences);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string'],
            'companyName' => ['required', 'string'],
            'startDate' => ['required', 'date'],
            'endDate' => ['nullable', 'date', Rule::requiredIf(!$request->isCurrentlyWorking), 'after:startDate'],
            'description' => ['nullable', 'string'],
            'isCurrentlyWorking' => ['required', 'boolean'],
            'exp_id' => ['nullable', 'integer']
        ]);

        $experience = $request->user()->workExperiences()->updateOrCreate([
            'id' => $request->input('exp_id')
        ],[
            'title' => $request->input('title'),
            'company_name' => $request->input('companyName'),
            'start_date' => Carbon::parse($request->input('startDate'))->format('Y-m-d'),
            'end_date' => (!is_null($request->input('endDate'))) ? Carbon::parse($request->input('endDate'))->format('Y-m-d') : null,
            'description' => $request->input('description'),
            'currently_working' => $request->input('isCurrentlyWorking'),
        ]);

        return new WorkExperienceResource($experience);
    }

    public function destroy(WorkExperience $experience)
    {
        $experience->delete();
        return response()->json(null, 200);
    }
}
