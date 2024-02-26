<?php

namespace App\Http\Controllers\Account\Resume;

use Illuminate\Http\Request;
use App\Models\Certification;
use App\Http\Controllers\Controller;

class CertificationController extends Controller
{
    public function index(Request $request)
    {
        $certifications = auth()->user()->certifications()->select([
            'id as certification_id',
            'certificate',
            'award_org',
            'summary',
            'start_year',
            'type'
        ])->where(
            'type', $request->get('type')
        )->get();

        return response()->json([
            'data' => $certifications
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'certificate' => ['required', 'string'],
            'award_org' => ['required', 'string'],
            'summary' => ['required'],
            'start_year' => ['required', 'numeric'],
            'certification_id' => ['nullable', 'integer'],
        ]);

        $certification = $request->user()->certifications()->updateOrCreate([
            'id' => $request->certification_id,
        ], [
            'certificate' => $request->input('certificate'),
            'award_org' => $request->input('award_org'),
            'summary' => $request->input('summary'),
            'start_year' => $request->input('start_year'),
            'type' => $request->input('type')
        ]);

        return response()->json([
            'data' => [
                'certification_id' => $certification->id,
                'certificate' => $certification->certificate,
                'award_org' => $certification->award_org,
                'summary' => $certification->summary,
                'start_year' => $certification->start_year,
                'type' => $certification->type,
            ]
        ]);
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();
        return response()->json(null, 200);
    }
}
