<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResumeUploadController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => auth()->user()->resume
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => [
                'mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain'
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

        return response()->json([
            'success' => true,
            'message' => 'Resume uploaded successfully',
            'data' => $cvUpload
        ]);
    }
}
