<x-auth.authenticate>
    @if (!request()->get('mode'))
        <div class="login-wapper">
            <h2 style="color: #05418d">Welcome</h2>
            <ul>
                <li>
                    <a href="{{ route('authenticate', ['mode' => 'login']) }}">
                        {{ __('Login') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('authenticate', ['mode' => 'register']) }}">
                        {{ __('Signup') }}
                    </a>
                </li>
            </ul>
        </div>
    @endif

    @if (request()->get('mode') === 'login' || request()->get('mode') === 'register')
        <div class="arrow">
            <a href="{{ route('authenticate') }}"></a>
        </div>
        <div class="login-wapper">
            <h2 style="color: #05418d">Welcome</h2>
            <h5>{{ request()->get('mode') === 'login' ? 'Login' : 'Registration' }} for</h5>
            <ul>
                @foreach ($userTypes as $type)
                    <li>
                        <a href="{{ route('authenticate', ['mode' => Str::slug($type . ' ' . request()->get('mode'))]) }}">
                            {{ $type }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (request()->get('mode') === 'applicant-login' || request()->get('mode') === 'campaign-login')
        <div class="arrow">
            <a href="{{ route('authenticate', ['mode' => end($goBackUrl)]) }}"></a>
        </div>
        <div class="login-wapper">
            <h2 style="color: #05418d">Welcome back</h2>
            <h5>Login for {{ request()->get('mode') === 'applicant-login' ? 'Applicant' : 'Campaign' }}</h5>
            <form id="password-form" action="{{ route('auth.login') }}" method="POST">
                @csrf

                <input name="mode" type="hidden" value="{{ request()->get('mode') }}">
                <div class="row">
                    <div class="wapper-form">
                        <label id="" for=""> </label>
                        <input class="email-label-new" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="email">
                        @error('email')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="wapper-form">
                        <label id="password-label" for=""></label>
                        <input class="pass-input-new" id="password" name="password" type="password" placeholder="password">

                        @error('password')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                    <span class="forgot">
                        <a href="{{ route('authenticate', ['mode' => 'forgot-pass']) }}">Forgot Password</a>
                    </span>
                    <button class="submit" type="submit">Submit</button>
                </div>
            </form>
            <span class="or">OR</span>
            <div class="login-id">
                @include('partials._social_logins')

                <span class="dont-account">
                    Don’t have a account?
                    <a
                        href="{{ route('authenticate', ['mode' => request()->get('mode') === 'applicant-login' ? 'applicant-register' : 'campaign-register']) }}">
                        Sign up
                    </a>
                </span>
            </div>
        </div>
    @endif

    @if (request()->get('mode') === 'applicant-register' || request()->get('mode') === 'campaign-register')
        <div class="arrow">
            <a href="{{ route('authenticate', ['mode' => end($goBackUrl)]) }}"></a>
        </div>
        <div class="login-wapper scrool-extra">
            <h2 style="color: #05418d">Welcome</h2>
            <h5 style="text-transform: none;">Lets get you setup with an account. Please provide the details below</h5>
            <form id="sing-up-form" action="{{ route('auth.register') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label id="name-label" for="">
                                <input id="name" name="first_name" type="text" value="{{ old('first_name') }}" placeholder="First name*">
                            </label>
                            @error('first_name')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label id="name-label" for="">
                                <input id="name" name="last_name" type="text" value="{{ old('last_name') }}" placeholder="Last Name*">
                            </label>
                            @error('last_name')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label id="name-label" for="">
                                <input id="name" name="email" type="email" value="{{ old('email') }}" placeholder="Email*">
                            </label>
                            @error('email')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label id="name-label" for="">
                                <input id="phone-no" name="phone_no" data-mask="(000) 000-0000" type="text" value="{{ old('phone_no') }}"
                                    placeholder="Phone*">
                            </label>
                            @error('phone_no')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label id="password-label" for="">
                                <input id="name" name="password" type="password" placeholder="Password*">
                            </label>
                            @error('password')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label id="password-label" for="">
                                <input id="name" name="password_confirmation" type="password" placeholder="Confirm Password*">
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="wapper-form">
                            <!-- <label id="" for="political_party"></label> -->
                            <select class="email-label-new" id="" name="political_group">
                                <option value="">{{ Str::title('select political party') }}</option>
                                <option value="democrat">Democrat</option>
                                <option value="republican">Republican</option>
                                <option value="nonpartisan">Nonpartisan</option>
                            </select>
                            @error('political_group')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="wapper-form">
                            <label id="text-area" for="">
                                <textarea id="" name="" placeholder="how did you hear about us ..."></textarea>
                            </label>
                        </div>
                    </div>
                    <input name="role" type="hidden" value="{{ request()->get('mode') === 'applicant-register' ? 'applicant' : 'campaign' }}">
                    <div class="col-lg-12">
                        <div class="wapper-form checkbox">
                            <span class="check-box">
                                <input id="checkbox" name="agree_terms" type="checkbox">
                                By signing up you're agreeing to our terms of service.
                            </span>
                            @error('agree_terms')
                                <small class="error-message">{{ $message }}</small>
                            @enderror

                        </div>
                        <button id="sing-up-submit" type="submit">Submit</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-lg-12">
                    <span class="or">OR</span>
                    <div class="login-id">
                        @include('partials._social_logins')
                    </div>
                    <span class="dont-account">
                        You have an account?
                        <a
                            href="{{ route('authenticate', ['mode' => request()->get('mode') === 'applicant-register' ? 'applicant-login' : 'campaign-login']) }}">
                            Login
                        </a>
                    </span>
                </div>
            </div>
        </div>
    @endif

    @if (request()->get('mode') == 'forgot-pass')
        <div class="arrow">
            <a href="{{ route('authenticate', ['mode' => 'login']) }}"></a>
        </div>
        <div class="login-wapper scrool-extra">
            <h2 style="color: #05418d">Welcome</h2>
            <h5 style="text-transform: none;">Forget Password ?</h5>
            <p style="font-size: 14px;line-height: 19px;margin-bottom: 40px;">Enter your email and we'll send you your username and a link to reset
                your password.</p>
            <form id="sing-up-form" action="{{ route('auth.forgot') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row">

                    <div class="col-lg-12">
                        <div class="wapper-form">
                            <label id="name-label" for="">
                                <input id="name" name="email" type="email" value="{{ old('email') }}" placeholder="Email*">
                            </label>
                            @error('email')
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <button id="sing-up-submit" type="submit" style="margin-top: 0;">Send Mail</button>
                </div>
            </form>

            <div class="row">
                <div class="col-lg-12">
                    <span class="or">OR</span>

                    <span class="dont-account">
                        You have an account?
                        <a
                            href="{{ route('authenticate', ['mode' => request()->get('mode') === 'applicant-register' ? 'applicant-login' : 'campaign-login']) }}">
                            Login
                        </a>
                    </span>
                </div>
            </div>
        </div>
    @endif
</x-auth.authenticate>

{{-- <script>
    window.history.forward();
    function noBack(){
        window.history.forward();
    }
</script> --}}
