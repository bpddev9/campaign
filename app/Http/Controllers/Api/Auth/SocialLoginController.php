<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class SocialLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'email',
            ],
            'social_id' => [
                'required',
                'string'
            ],
            'role' => [
                'required',
                'string',
                Rule::in(['applicant', 'campaign'])
            ],
            'service' => [
                'required',
                'string',
                Rule::in(['facebook', 'google', 'apple'])
            ],
        ]);

        $user = User::where('email', $request->input('email'))->orWhereHas('socials', function ($query) use($request) {
            $query->where('social_id', $request->input('social_id'))->where('service', $request->input('service'));
        })->first();
        
        if (!$user) {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
            ]);
        }

        if ($this->needsToCreateSocial($user, $request->input('service'))) {
            $user->socials()->create([
                'social_id' => $request->input('social_id'),
                'service' => $request->input('service'),
            ]);
        }

        if ($user->tokens()->count()) {
            $user->tokens()->delete();
        }

        $token = $user->createToken('app-token')->plainTextToken;

        return (new UserResource($user))->additional([
            'meta' => [
                'access_token' => $token
            ]
        ]);
    }

    private function needsToCreateSocial($user, $service)
    {
        return !$user->socialAccountLinked($service);
    }
}
