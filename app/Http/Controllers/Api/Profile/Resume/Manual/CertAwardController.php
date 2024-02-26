<?php

namespace App\Http\Controllers\Api\Profile\Resume\Manual;

use Illuminate\Http\Request;
use App\Models\Certification;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\Manual\CertAwardResource;

class CertAwardController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'type' => ['required', 'string', Rule::in(['certification', 'award'])]
        ]);

        $certifications = auth()->user()->certifications()->where(
            'type', $request->get('type')
        )->latest()->get();

        return CertAwardResource::collection($certifications);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'certificate' => ['required', 'string'],
            'award_org' => ['required', 'string'],
            'summary' => ['required'],
            'start_year' => ['required', 'numeric'],
            'cert_id' => ['nullable', 'integer'],
            'type' => ['required', 'string', Rule::in(['certification', 'award'])]
        ]);

        $certification = $request->user()->certifications()->updateOrCreate([
            'id' => $request->input('cert_id'),
        ], [
            'certificate' => $request->input('certificate'),
            'award_org' => $request->input('award_org'),
            'summary' => $request->input('summary'),
            'start_year' => $request->input('start_year'),
            'type' => $request->input('type')
        ]);

        return new CertAwardResource($certification);
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();
        return response()->json(null, 200);
    }
}
