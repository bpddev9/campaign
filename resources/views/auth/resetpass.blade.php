<x-auth.authenticate>
    <div class="login-wapper scrool-extra">
        <h2 style="color: #05418d">Welcome</h2>
        <h5 style="text-transform: none;">Reset Your Password</h5>
        <form id="sing-up-form" action="{{ route('auth.reset') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row">

                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="email" type="email" value="{{ $email }}" placeholder="Email*" readonly>
                        </label>
                        @error('email')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="password" type="password" placeholder="New Passowrd">
                        </label>
                        @error('password')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="password_confirmation" type="password" placeholder="Confirm New Password">
                        </label>
                        @error('password_confirmation')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <button id="sing-up-submit" type="submit">Submit</button>
            </div>
        </form>
    </div>
</x-auth.authenticate>
