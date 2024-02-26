<?php

namespace App\Http\Controllers\Api\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserProfileController extends Controller
{
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => [
                'required'
            ],
            'new_password' => [
                'required',
                Password::min(8)->mixedCase()->letters()->symbols()->numbers(),
                'confirmed'
            ]
        ]);

        if (Hash::check($request->old_password, $request->user()->password)) {
            $request->user()->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'msz' => 'Updated Successfully'
            ]);
        } else {
            throw ValidationException::withMessages(['old_password' => 'Old Password is incorrect']);
        }
    }
}
