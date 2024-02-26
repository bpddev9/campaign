<?php

namespace App\Http\Controllers\Account\Resume;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WorkExperience;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class WorkExpController extends Controller
{
    public function index()
    {
        $myExperiences = auth()->user()->workExperiences()->get()->map(function ($item, $key) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'companyName' => $item->company_name,
                'startDate' => $item->start_date,
                'endDate' => !is_null($item->end_date) ? $item->end_date : null,
                'description' => $item->description,
                'isCurrentlyWorking' => (bool) $item->currently_working,
            ];
        });

        return $myExperiences->toJson();
    }

    public function single($param)
    {
        $experience = WorkExperience::find($param);

        return response()->json([
            'id' => $experience->id,
            'title' => $experience->title,
            'companyName' => $experience->company_name,
            'startDate' => Carbon::parse($experience->start_date)->format('m/d/Y'),
            'endDate' => !is_null($experience->end_date) ? Carbon::parse($experience->end_date)->format('m/d/Y') : null,
            'description' => $experience->description,
            'isCurrentlyWorking' => (bool) $experience->currently_working,
        ]);
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
            'id' => ['nullable', 'integer']
        ]);

        $experience = $request->user()->workExperiences()->updateOrCreate([
            'id' => $request->input('id')
        ],[
            'title' => $request->input('title'),
            'company_name' => $request->input('companyName'),
            'start_date' => Carbon::parse($request->input('startDate'))->format('Y-m-d'),
            'end_date' => (!is_null($request->input('endDate'))) ? Carbon::parse($request->input('endDate'))->format('Y-m-d') : null,
            'description' => $request->input('description'),
            'currently_working' => $request->input('isCurrentlyWorking'),
        ]);

        return response()->json([
            'data' => [
                'id' => $experience->id,
                'title' => $experience->title,
                'companyName' => $experience->company_name,
                'startDate' => $experience->start_date,
                'endDate' => $experience->end_date,
                'description' => \Str::limit($experience->description, 80),
                'isCurrentlyWorking' => $experience->currently_working,
            ]
        ]);
    }

    public function update(WorkExperience $experience, Request $request)
    {
        //
    }

    public function destroy(WorkExperience $experience)
    {
        $experience->delete();
        return response()->json(null, 200);
    }
}
