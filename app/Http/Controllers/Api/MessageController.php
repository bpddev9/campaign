<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ApplicantMessageMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'applicant_id' => ['required'],
            'msz_subject' => ['required'],
            'msz_body' => ['required']
        ]);

        $applicant = User::select('name', 'email')->find($request->applicant_id);

        $data = [
            'msz_sub' => $request->msz_subject,
            'msz_body' => $request->msz_body,
            'msz_from' => $request->user()->companyProfile->company_name
        ];

        Mail::to($applicant->email)->send(new ApplicantMessageMail($data));

        return response()->json([
            'msz' => 'Sent Successfully'
        ]);
    }
}
