<?php

namespace App\Http\Controllers\Account\Resume;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function index()
    {
        $publications = auth()->user()->publications()->select([
            'id as publication_id',
            'title',
            'publisher',
            'summary'
        ])->get();

        return response()->json([
            'data' => $publications
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string'],
            'publisher' => ['required', 'string'],
            'summary' => ['required', 'string'],
            'publication_id' => ['nullable', 'integer']
        ]);

        $publication = $request->user()->publications()->updateOrCreate([
            'id' => $request->publication_id
        ], [
            'title' => $request->input('title'),
            'publisher' => $request->input('publisher'),
            'summary' => $request->input('summary'),
        ]);

        return response()->json([
            'data' => [
                'publication_id' => $publication->id,
                'title' => $publication->title,
                'publisher' => $publication->publisher,
                'summary' => $publication->summary,
            ]
        ]);
    }

    public function destroy()
    {
        //
    }
}
