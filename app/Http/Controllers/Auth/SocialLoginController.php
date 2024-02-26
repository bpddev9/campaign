<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service, Request $request)
    {
        $serviceUser = Socialite::driver($service)->user();
        
        $user = $this->getExistingUser($serviceUser, $service);

        if (!$user) {
            $user = User::create([
                'name' => $serviceUser->name,
                'email' => $serviceUser->email,
                'role' => session()->get('role'),
            ]);

            $user->socials()->create([
                'social_id' => $serviceUser->id,
                'service' => $service,
            ]);

            session()->forget('role');
        }

        auth()->login($user);

        return redirect()->route('my.account');
    }

    private function getExistingUser($serviceUser, $service)
    {
        return User::where(
            'email', $serviceUser->email
        )->orWhereHas('socials', function ($query) use($serviceUser, $service) {
            $query->where('social_id', $serviceUser->id)->where('service', $service);
        })->first();
    }
}
