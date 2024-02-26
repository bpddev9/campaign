<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\EmailVerify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    public function forgot(Request $request){
        $this->validate($request, [
            'email' => ['required', 'email', 'exists:users,email']
        ], [
            'email.exists' => 'User Not Found'
        ]);

        $user = User::where('email', $request->email)->first();

        $data = [
            'email' => $user->email,
            'code' => rand(10000, 99999),
            'expire_at' => now()->addMinutes(5)
        ];

        EmailOtp::updateOrCreate([
            'user_id' => $user->id
        ], $data);

        Mail::to($user->email)->send(new EmailVerify($data));

        return response()->json(['data' => ['email' => $user->email], 'message' => 'A link was sent to verify your email']);

    }

    public function verify(Request $request){
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
                    $otp->delete();

                    return response()->json(['data' => ['email' => $otp->email], 'message' => 'Email verified successfully']);
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

    public function reset(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8)->mixedCase()->letters()->symbols()->numbers(), 'confirmed']
        ]);

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'Password Reset Successful']);
    }
}
