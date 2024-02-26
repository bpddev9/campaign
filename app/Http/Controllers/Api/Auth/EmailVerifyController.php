<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\EmailVerify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class EmailVerifyController extends Controller
{
    public function verify(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'code' => ['required']
        ]);

        $otp = EmailOtp::where('email', $request->email)->first();
        if ($otp) {
            if (now() > $otp->expire_at) {
                throw ValidationException::withMessages([
                    'code' => 'Code Expired, Send Again'
                ]);
            } else {
                if ($request->code == $otp->code) {
                    $user = User::where('email', $request->email)->first();
                    $user->update([
                        'email_verified_at' => now()
                    ]);
                    $token = $user->createToken('app-token')->plainTextToken;
                    $otp->delete();

                    return (new UserResource($user))->additional([
                        'meta' => [
                            'access_token' => $token
                        ]
                    ]);
                } else {
                    throw ValidationException::withMessages([
                        'code' => 'Code does not match'
                    ]);
                }
            }
        }
        else {
            throw ValidationException::withMessages([
                'code' => 'OTP not found'
            ]);
        }
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $data = [
                'email' => $request->email,
                'code' => rand(10000, 99999),
                'expire_at' => now()->addMinutes(5)
            ];

            EmailOtp::updateOrCreate([
                'user_id' => $user->id
            ], $data);

            Mail::to($request->email)->send(new EmailVerify($data));

            return response()->json(['data' => ['email' => $request->email], 'message' => 'Code Resent Successfully']);
        }
    }
}
