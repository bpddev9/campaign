<?php

namespace App\Http\Controllers\Api\Profile\Resume\Manual;

use App\Models\Publication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Manual\PublicationResource;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $publications = $request->user()->publications()->get();
        return PublicationResource::collection($publications);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', 'string'],
            'publisher' => ['required', 'string'],
            'summary' => ['required', 'string'],
            'pub_id' => ['nullable', 'integer']
        ]);

        $publication = $request->user()->publications()->updateOrCreate([
            'id' => $request->input('pub_id')
        ], [
            'title' => $request->input('title'),
            'publisher' => $request->input('publisher'),
            'summary' => $request->input('summary'),
        ]);

        return new PublicationResource($publication);
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();
        return response()->json(null, 200);
    }
}
