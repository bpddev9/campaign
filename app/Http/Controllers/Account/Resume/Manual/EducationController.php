<?php

namespace App\Http\Controllers\Account\Resume\Manual;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $edus = Qualification::where('user_id', auth()->id())->get();

        $years = range(1990, strftime("%Y", time()));

        return view('account.resume.manual.education', [
            'years' => $years,
            'edus' => $edus
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'institute_name' => ['required', 'string'],
            'degree' => ['required', 'string'],
            'start_year' => ['required', 'numeric'],
            'end_year' => ['required', 'numeric', 'gte:start_year'],
        ]);

        $request->user()->qualifications()->updateOrCreate([
            'id' => $request->qualification_id,
        ],[
            'institute_name' => $request->input('institute_name'),
            'degree' => $request->input('degree'),
            'start_year' => $request->input('start_year'),
            'end_year' => $request->input('end_year'),
        ]);

        return redirect()->route('manual.education')->with('success', 'Saved Successfully');
    }

    public function edit($id){
        $edus = Qualification::where('user_id', auth()->id())->get();
        $years = range(1990, strftime("%Y", time()));
        $edu = Qualification::where('id', $id)->where('user_id', auth()->id())->first();

        return view('account.resume.manual.education', ['edu' => $edu, 'years' => $years, 'edus' => $edus]);
    }

    public function delete($id){
        $edu = Qualification::where('id', $id)->where('user_id', auth()->id())->first();
        $edu->delete();

        return redirect()->route('manual.education')->with('success', 'Education Updated');
    }
}
