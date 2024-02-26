<?php

namespace App\Http\Controllers\Account\Resume\Manual;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertifiController extends Controller
{
    public function index()
    {
        $years = range(1990, strftime("%Y", time()));
        $certs = Certification::where('user_id', auth()->id())->where('type', 'certification')->get();
        return view('account.resume.manual.certification', [
            'years' => $years, 'certs' => $certs
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'certificate' => ['required', 'string'],
            'award_org' => ['required', 'string'],
            'summary' => ['required'],
            'start_year' => ['required', 'numeric'],
        ]);

        $request->user()->certifications()->updateOrCreate([
            'id' => $request->cert_id,
        ],[
            'certificate' => $request->input('certificate'),
            'award_org' => $request->input('award_org'),
            'summary' => $request->input('summary'),
            'start_year' => $request->input('start_year'),
            'user_id' => $request->input('user_id'),
        ]);

        return redirect()->route('manual.certification')->with('success', 'Saved Successfully');
    }

    public function edit($id){
        $years = range(1990, strftime("%Y", time()));
        $certs = Certification::where('user_id', auth()->id())->get();
        $cert = Certification::where('id', $id)->where('type', 'certification')->where('user_id', auth()->id())->first();

        return view('account.resume.manual.certification', ['cert' => $cert, 'certs' => $certs, 'years' => $years]);
    }

    public function delete($id){
        $cert = Certification::where('id', $id)->where('type', 'certification')->where('user_id', auth()->id())->first();
        $cert->delete();
        return back()->with('success', 'Certification Deleted');
    }
}
