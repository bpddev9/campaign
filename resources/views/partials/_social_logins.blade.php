<ul class="login-holder">
    <li>
        <a href="{{ url('/authenticate/social-login/google') }}">
            <span>
                <img src="{{ asset('images/Icon-Google.svg') }}" alt="">
            </span>
            login with google
        </a>
    </li>
    <li>
        <a href="{{ url('/authenticate/social-login/facebook') }}">
            <span>
                <img src="{{ asset('images/Icon-Facebook.svg') }}" alt="">
            </span>
            login with facebook
        </a>
    </li>
</ul>