<x-layouts.app>
    <section class="splash-screen">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="main-wapper-img">
                        <div class="splash-slick-slider">
                            <div class="element element-2">
                                <div class="fig-holder">
                                    <figure style="background-image: url({{ asset('images/campping-2.png') }});">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="main-text">
                        <div class="text-wapper">
                            <div class="text px-5">
                                <p style="font-size: 35px; color:aliceblue;">Campaign Express instantly connects you to
                                    candidates and/or campaign consultants and staff in
                                    your district. Once you are signed up, you can choose from any jobs at municipal,
                                    state or federal level</p>
                                <div class="arrow">
                                    <a href="{{ url('/authenticate') }}"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
