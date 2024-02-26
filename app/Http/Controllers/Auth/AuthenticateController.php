<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\EmailOtp;
use App\Mail\ResetPassMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\WebEmailVerify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class AuthenticateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest'])->except('logout');
    }

    public function index(Request $request)
    {
        $userTypes = collect(['applicant', 'campaign']);
        $userTypes = $userTypes->map(fn ($type, $key) => $type)->toArray();
        $goBackUrl = '';

        if ($request->get('mode')) {
            $goBackUrl = explode('-', $request->get('mode'));
            session()->put('role', current($goBackUrl));
        }

        return view('auth.authenticate', compact('userTypes', 'goBackUrl'));
    }

    public function verification()
    {
        return view('auth.verify');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'mode' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        $mode = $request->mode;

        if ($user && is_null($user->email_verified_at)) {
            $data = [
                'email' => $user->email,
                'code' => Str::uuid(),
                'expire_at' => now()->addMinutes(5)
            ];

            EmailOtp::updateOrCreate([
                'user_id' => $user->id
            ], $data);

            Mail::to($user->email)->send(new WebEmailVerify($data));

            return redirect()->route('authenticate')->with('success', 'Verification link Sent to your email');
        } else {
            if (Auth::attemptWhen([
                'email' => $request->email,
                'password' => $request->password,
            ], function ($user) use ($mode) {
                $t = explode('-', $mode);
                return current($t) === $user->role;
            })) {
                $request->session()->regenerate();
                return redirect()->route('my.account');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
    }

    public function register(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'first_name' => 'required|string|alpha',
            'last_name' => 'required|string|alpha',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                Password::min(8)->mixedCase()->letters()->symbols()->numbers(),
                'confirmed'
            ],
            'phone_no' => 'required|unique:users',
            'political_group' => 'required',
            'agree_terms' => 'required',
        ], [
            'password.confirmed' => "The password do not match"
        ]);

        $user = User::create([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_no' => $request->input('phone_no'),
            'role' => $request->input('role'),
            'political_group' => $request->input('political_group'),
            'password' => Hash::make($request->input('password')),
        ]);

        $data = [
            'email' => $user->email,
            'code' => Str::uuid(),
            'expire_at' => now()->addMinutes(5)
        ];

        EmailOtp::updateOrCreate([
            'user_id' => $user->id
        ], $data);

        Mail::to($user->email)->send(new WebEmailVerify($data));

        return back()->with('success', 'Verification link Sent to your email');
    }

    public function verifyEmail($email, $token)
    {
        $code = EmailOtp::where('email', $email)->first();
        if ($code->code == $token) {
            $user = User::where('email', $email)->first();
            $user->update([
                'email_verified_at' => now()
            ]);
            $code->delete();
            auth()->login($user);
            return redirect()->route('my.account');
        } else {
            abort(404);
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'User Not Found'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $data = [
                'email' => $user->email,
                'code' => Str::uuid(),
                'expire_at' => now()->addMinutes(5)
            ];

            EmailOtp::updateOrCreate([
                'user_id' => $user->id
            ], $data);

            Mail::to($request->email)->send(new ResetPassMail($data));

            return redirect()->route('authenticate')->with('success', 'Email Sent Successfully');
        } else {
            return back()->with('success', 'User Not Found');
        }
    }

    public function resetview($email, $token)
    {
        $code = EmailOtp::where('email', $email)->first();

        if ($code->code == $token) {
            $code->delete();
            return view('auth.resetpass', ['email' => $email]);
        }
        else {
            abort('404');
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => [
                'required',
                Password::min(8)->mixedCase()->letters()->symbols()->numbers(),
                'confirmed'
            ],
            'password_confirmation' => 'required'
        ], [
            'password.confirmed' => 'Password doesnot match'
        ]);

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        Session::flush();

        return redirect()->route('authenticate')->with('success', 'Password Reset Successful');
    }
}
