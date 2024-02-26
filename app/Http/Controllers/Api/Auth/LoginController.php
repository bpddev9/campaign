<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\EmailVerify;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => [
                'required',
                Rule::in(['applicant', 'campaign'])
            ],
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect'
            ]);
        }

        if ($user && is_null($user->email_verified_at)) {
            $data = [
                'email' => $user->email,
                'code' => rand(10000, 99999),
                'expire_at' => now()->addMinutes(5)
            ];
    
            EmailOtp::updateOrCreate([
                'user_id' => $user->id
            ], $data);
    
            Mail::to($request->email)->send(new EmailVerify($data));

            return (new UserResource($user))->additional([
                'verified' => false,
                'message' => 'A link was sent to verify your email'
            ]);
        }

        if ($user && $user->role !== $request->input('role')) {
            throw ValidationException::withMessages([
                'email' => 'The given user role is incorrect'
            ]);
        }

        $token = $user->createToken('app-token')->plainTextToken;

        return (new UserResource($user))->additional([
            'verified' => true,
            'meta' => [
                'access_token' => $token
            ]
        ]);
    }
}
