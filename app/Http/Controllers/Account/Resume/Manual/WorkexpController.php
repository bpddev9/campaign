<?php

namespace App\Http\Controllers\Account\Resume\Manual;

use Illuminate\Http\Request;
use App\Models\WorkExperience;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class WorkexpController extends Controller
{
    public function index()
    {
        $exps = WorkExperience::where('user_id', auth()->id())->get();
        return view('account.resume.manual.work-experience', ['exps' => $exps]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'company_name' => 'required',
            'start_date' => 'required|date',
            'end_date' => [
                'nullable',
                'date',
                Rule::requiredIf($request->currently_working === '0'),
                'after:start_date'
            ],
            'currently_working' => 'nullable|boolean',
            'description' => 'nullable',
        ]);

        $request->user()->workExperiences()->updateOrCreate([
            'id' => $request->input('work_id')
        ], [
            'title' => $request->input('title'),
            'company_name' => $request->input('company_name'),
            'start_date' => Carbon::parse($request->input('start_date'))->format('Y-m-d'),
            'end_date' => ($request->has('end_date') && !is_null($request->input('end_date'))) ? Carbon::parse($request->input('endDate'))->format('Y-m-d') : null,
            'description' => $request->input('description'),
            'currently_working' => $request->input('currently_working'),
        ]);

        return redirect()->route('manual.work-experience')->with('success', 'Saved Successfully');
    }

    public function edit($id)
    {
        $work = WorkExperience::where('id', $id)->where('user_id', auth()->id())->first();
        $exps = WorkExperience::where('user_id', auth()->id())->get();
        return view('account.resume.manual.work-experience', ['work' => $work, 'exps' => $exps]);
    }

    public function delete($id)
    {
        $work = WorkExperience::where('id', $id)->where('user_id', auth()->id())->first();
        $work->delete();
        return back()->with('success', 'Deleted Updated');
    }
}
