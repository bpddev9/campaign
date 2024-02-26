<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\EmailVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'first_name' => [
                'required',
                'string',
                'alpha'
            ],
            'last_name' => [
                'required',
                'string',
                'alpha'
            ],
            'email' => [
                'required',
                'email',
                'unique:users'
            ],
            'password' => [
                'required',
                Password::min(8)->mixedCase()->letters()->symbols()->numbers(),
                'confirmed'
            ],
            'phone_no' => [
                'required',
                'unique:users',
                'phone:US'
            ],
            'role' => [
                'required',
                'string',
                Rule::in(['applicant', 'campaign'])
            ],
            'political_group' => [
                'required',
                'string',
                Rule::in(['democrat', 'republican', 'nonpartisan'])
            ]
        ]);

        $user = User::create([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'phone_no' => $request->input('phone_no'),
            'political_group' => Str::title($request->input('political_group')),
        ]);

        $data = [
            'email' => $user->email,
            'code' => rand(10000, 99999),
            'expire_at' => now()->addMinutes(5)
        ];

        EmailOtp::updateOrCreate([
            'user_id' => $user->id
        ], $data);

        Mail::to($user->email)->send(new EmailVerify($data));

        return response()->json(['data' => ['email' => $request->email], 'message' => 'A link was sent to verify your email']);
    }
}
