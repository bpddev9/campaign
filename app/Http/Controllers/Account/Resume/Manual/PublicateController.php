<?php

namespace App\Http\Controllers\Account\Resume\Manual;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;

class PublicateController extends Controller
{
    public function index()
    {
        $pubs = Publication::where('user_id', auth()->id())->get();
        return view('account.resume.manual.publication', ['pubs' => $pubs]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string'],
            'publisher' => ['required', 'string'],
            'summary' => ['required', 'string'],
        ]);

        $request->user()->publications()->updateOrCreate([
            'id' => $request->pub_id,
        ],[
            'title' => $request->input('title'),
            'publisher' => $request->input('publisher'),
            'summary' => $request->input('summary')
        ]);

        return redirect()->route('manual.publication')->with('success', 'Saved Successfully');
    }

    public function edit($id)
    {
        $pubs = Publication::where('user_id', auth()->id())->get();
        $pub = Publication::where('id', $id)->where('user_id', auth()->id())->first();

        return view('account.resume.manual.publication', ['pub' => $pub, 'pubs' => $pubs]);
    }

    public function delete($id){
        $pub = Publication::where('id', $id)->where('user_id', auth()->id())->first();
        $pub->delete();
        return back()->with('success', 'Publication Deleted');
    }
}
