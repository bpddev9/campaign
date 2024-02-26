<header class="main-header-home-login">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="logo-main">
                    <img src="{{ asset('images/Logo-Original-main.svg') }}" alt="">
                </div>
            </div>
            @auth
                <div class="col-lg-6">
                    <x-profile-link/>
                </div>
                @include('partials._logout_form')
            @endauth
        </div>
        <div class="add-section-top">
            <div class="fig-holder">
                <figure style="background-image: url({{ asset('images/add-banner.jpg') }})"></figure>
            </div>
        </div>
    </div>
</header>
