<?php

namespace App\Http\Controllers\Api\Profile\Resume\Manual;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Manual\LinkResource;

class MyLinkController extends Controller
{
    public function index()
    {
        $links = auth()->user()->links()->latest()->get();

        return LinkResource::collection($links);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'link_id' => 'nullable|numeric|exists:links,id',
            
            'link_title' => [
                'required',
                'string'
            ],
            
            'link_url' => [
                'required',
                'url'
            ],
        ]);

        $link = $request->user()->links()->updateOrCreate([
            'id' => $request->input('link_id'),
        ], [
            'link_title' => $request->input('link_title'),
            'link_url' => $request->input('link_url'),
        ]);

        return new LinkResource($link);
    }

    public function destroy($id)
    {
        $link = auth()->user()->links()->where('id', $id)->first();

        $link->delete();

        return response()->json(null, 200);
    }
}
