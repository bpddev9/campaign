<?php

namespace App\Http\Controllers\Account\Resume\Manual;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    public function index()
    {
        $awards = Certification::where('user_id', auth()->id())->where('type', 'award')->get();
        $years = range(1990, strftime("%Y", time()));

        return view('account.resume.manual.award', [
            'years' => $years, 'awards' => $awards
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'award' => ['required', 'string'],
            'award_org' => ['required', 'string'],
            'summary' => ['required'],
            'start_year' => ['required', 'numeric'],
        ]);

        $request->user()->certifications()->updateOrCreate([
            'id' => $request->award_id,
        ],[
            'certificate' => $request->input('award'),
            'award_org' => $request->input('award_org'),
            'summary' => $request->input('summary'),
            'start_year' => $request->input('start_year'),
            'type' => 'award',
        ]);
        
        return redirect()->route('manual.award')->with('success', 'Saved Successfully');
        
    }

    public function edit($id){
        $years = range(1990, strftime("%Y", time()));
        $awards = Certification::where('user_id', auth()->id())->where('type', 'award')->get();
        $award = Certification::where('id', $id)->where('type', 'award')->where('user_id', auth()->id())->first();
        return view('account.resume.manual.award', ['award' => $award, 'years' => $years, 'awards' => $awards]);
    }

    public function delete($id){
        $award = Certification::where('id', $id)->where('type', 'award')->where('user_id', auth()->id())->first();
        $award->delete();
        return back()->with('success', 'Award Deleted');
    }

}
