<?php

namespace App\Http\Controllers\Account\Resume\Manual;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    public function index()
    {
        $links = auth()->user()->links()->get();

        return view('account.resume.manual.link', compact('links'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'link_id' => 'nullable|numeric',
            'link_title' => ['required', 'string'],
            'link_url' => ['required', 'url'],
        ]);

        $request->user()->links()->updateOrCreate([
            'id' => $request->input('link_id'),
        ], [
            'link_title' => $request->input('link_title'),
            'link_url' => $request->input('link_url'),
        ]);

        return redirect()->route('manual.links')->with('success', 'Link saved successfully');
    }

    public function edit($id)
    {
        $link = Link::find($id);
        $links = auth()->user()->links()->get();
        return view('account.resume.manual.link', compact('link', 'links'));
    }

    public function destroy($id)
    {
        $link = Link::find($id);
        $link->delete();
        return redirect()->route('manual.links.index')->with('success', 'Link deleted successfully');
    }
}
