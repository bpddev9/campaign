<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper search-result-main">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <div class="manin-wapper">
            <div class="heading">
                <h5>all Applicants</h5>
            </div>
            <div class="text">
                @if (!$applicants->count())
                    <p class="lead fs-5 fw-bold text-warning">There isn't any Applicants</p>
                @else
                    @foreach ($applicants as $applicant)
                        <div class="fst-sec">
                            <h3 style="color: #38b9b9;">{{ $applicant->name }}</h3>
                            <ul>
                                <li>
                                    Phone: <span>
                                        <img src="{{ asset('images/Icon-Calendar.svg') }}" alt=""></span>
                                    {{ $applicant->phone_no}}
                                </li>
                                <li>
                                    Email: <span>
                                        <img src="{{ asset('images/Icon-Calendar.svg') }}" alt=""></span>
                                    {{ $applicant->email}}
                                </li>
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</x-auth.authenticate>
