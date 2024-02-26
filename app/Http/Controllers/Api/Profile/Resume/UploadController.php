<?php

namespace App\Http\Controllers\Api\Profile\Resume;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResumeResource;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user.role:applicant']);
    }

    public function index(Request $request)
    {
        $resume = $request->user()->resume;
        return new ResumeResource($resume);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => [
                'mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain'
            ],
            'upload_id' => [
                'nullable',
                'integer',
                'exists:resumes,id'
            ]
        ], [
            'file' => 'Only pdf, docx and txt files are allowed'
        ]);

        if (optional($request->user()->resume)->file_path !== null) {
            unlink(storage_path('app/public/' . $request->user()->resume->file_path));
        }

        $filePath = $request->file('file')->store('uploads/resumes', 'public');

        $cvUpload = $request->user()->resume()->updateOrCreate([
            'id' => $request->input('upload_id')
        ], [
            'file_name' => $request->file('file')->getClientOriginalName(),
            'mime_type' => $request->file('file')->getMimeType(),
            'file_path' => $filePath,
            'file_ext' => $request->file('file')->extension(),
        ]);

        return new ResumeResource($cvUpload);
    }
}
