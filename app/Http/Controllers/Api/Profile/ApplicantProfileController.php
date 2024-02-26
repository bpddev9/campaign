<?php

namespace App\Http\Controllers\Api\Profile;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ApplicantProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['user.role:applicant']);
    }

    public function index(Request $request)
    {
        $profile = $request->user()->load('profile');

        return new UserResource($profile);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string'
            ],
            'street_address' => [
                'required',
            ],
            'city' => [
                'required'
            ],
            'state' => [
                'required'
            ],
            'zip_code' => [
                'required',
                'numeric'
            ],
            'political_group' => [
                'required',
                'string',
                Rule::in(['democrat', 'republican', 'nonpartisan'])
            ],
            'profile_pic' => [
                'nullable',
                'image'
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
            'political_group' => $request->input('political_group')
        ]);

        $request->user()->profile()->updateOrCreate([
            'user_id' => auth()->id()
        ], [
            'street_address' => $request->input('street_address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip_code' => $request->input('zip_code'),
            'profile_pic' => $filePath
        ]);

        return new UserResource($request->user()->load('profile'));
    }
}
