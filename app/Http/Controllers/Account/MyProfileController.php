<?php

namespace App\Http\Controllers\Account;

use App\Models\Resume;
use App\Mail\ApplyJobMail;
use App\Models\Employment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MyProfileController extends Controller
{
    public function index(Request $request)
    {
        if (!is_null($request->user()->profile) && !is_null($request->user()->profile->profile_pic)) {
            $profile_pic = asset('storage/' . $request->user()->profile->profile_pic);
        } else {
            $profile_pic = asset('images/profile.png');
        }

        return view('account.profile.index', compact('profile_pic'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(auth()->id()),
            ],
            'phone_no' => [
                'required',
                Rule::unique('users')->ignore(auth()->id()),
            ],
            'street_address' => [
                'required',
            ],
            'political_group' => [
                'required',
            ],
            'profile_pic' => [
                'nullable',
                'image',
            ]
        ]);

        $filePath = null;

        if (!is_null($request->user()->profile) && !is_null($request->user()->profile->profile_pic)) {
            $filePath = $request->user()->profile->profile_pic;
        }

        if ($request->has('profile_pic')) {
            if (!is_null($request->user()->profile) && !is_null($request->user()->profile->profile_pic)) {
                unlink(storage_path('app/public/' . $request->user()->profile->profile_pic));
            }

            $filePath = $request->file('profile_pic')->store('uploads/profile', 'public');
        }

        $request->user()->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'political_group' => $request->input('political_group'),
        ]);

        $request->user()->profile()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'street_address' => $request->input('street_address'),
            'profile_pic' => $filePath
        ]);

        return response()->json([
            'status' => 'success',
            'msg' => 'Profile information saved successfully',
            'redirect_url' => '/my-account/profile/applicant'
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'street_address' => 'required',
            'file' => [
                'mimetypes:application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain'
            ]
        ], [
            'file' => 'Only pdf, docx and txt files are allowed'
        ]);

        $questAns = null;

        if ($request->has('answer')) {
            $questAns = collect($request->input('answer'))->map(fn ($item, $key) => [
                'q_no' => $key + 1,
                'answer' => $item
            ])->toJson();
        }

        $jobid = $request->jobid;

        // update user
        $request->user()->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
        ]);

        // update user profile
        $request->user()->profile()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'street_address' => $request->input('street_address'),
        ]);

        if (!is_null($request->file('resume_file'))) {
            // delete existing resume
            if (optional($request->user()->resume)->file_name !== null) {
                unlink(storage_path('app/public/' . $request->user()->resume->file_path));
            }

            // store new resume
            $filePath = $request->file('resume_file')->store('uploads/resumes', 'public');

            // update resume
            $request->user()->resume()->updateOrCreate([
                'user_id' => auth()->id()
            ], [
                'file_name' => $request->file('resume_file')->getClientOriginalName(),
                'mime_type' => $request->file('resume_file')->getMimeType(),
                'file_path' => $filePath
            ]);
        }

        // send mail
        $job = Employment::with('user')->where('id', $jobid)->first();

        auth()->user()->jobs()->attach($jobid, [
            'quest_ans' => $questAns,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!is_null($request->file('resume_file'))) {
            $path_file = $filePath;
        } else {
            $path_file = optional(auth()->user()->resume)->file_path;
        }

        Mail::to($job->user->email)->send(new ApplyJobMail($job, $request->user(), $job->can_post_resume, $path_file));

        return response()->json(['message' => 'Job Applied Successfully']);
    }
}
