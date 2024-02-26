<x-layouts.app>
    <section class="home-login {{ (Route::is('authenticate') || Route::is('reset.view')) ? 'main-page-start' : '' }}">
        <div class="container-fluid">
            <div class="main-wapper">
                <div class="row">
                    <div class="col-md-6 p-0">
                        @if (Route::is('authenticate') || Route::is('reset.view'))
                            <div class="home-page-logo-wapper">
                                <div class="logo-main">
                                    <img src="{{ asset('images/Logo-Original-main.svg') }}" alt="">
                                </div>
                                <p>Campaign Express instantly connects you to
                                    candidates and/or campaign consultants and
                                    staff in your district. Once you are signed up,
                                    you can choose from any jobs at municipal,
                                    state or federal level</p>
                            </div>
                        @else
                        <div class="home-page-logo-wapper extra-logo-wapper">
                            <div class="logo-main">
                                <img src="{{ asset('images/Logo-Original-main.svg') }}" alt="">
                            </div>
                            <p>
                                Campaign Express instantly connects you to
                                candidates and/or campaign consultants and
                                staff in your district. Once you are signed up,
                                you can choose from any jobs at municipal,
                                state or federal level
                            </p>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6 p-0">
                        <div
                            class="login-form
                            @if (auth()->check())
                                @if (auth()->user()->political_group === 'democrat')
                                domocrat-class
                                @elseif(auth()->user()->political_group === 'republican')
                                republican-class
                                @else
                                nonparty-class
                                @endif
                             @endif">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</x-layouts.app>
