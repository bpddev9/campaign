<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper search-result-main">
        <h2 x-text="userRole"></h2>
        <div class="manin-wapper">
            <div class="heading">
                <h5>Applied jobs</h5>
            </div>
            <div class="text">

                @forelse($jobs as $job)

                    <div class="fst-sec">
                        <h3>{{$job->job_title}}</h3>
                        <p>{{$job->user->companyProfile->company_name}}</p>
                        <ul>
                            <li>
                                <span><img src="{{ asset('images/Icon-Calendar.svg') }}" alt=""></span>
                                <span>{{$job->job_type}}</span>
                            </li>
                            <li>
                                <span><img src="{{ asset('images/Icon-Location.svg') }}" alt=""></span>
                                <span>{{$job->location_type}}</span>
                            </li>
                            <li>
                                <span><img src="{{ asset('images/icon-time.svg') }}" alt=""></span>
                                <span>{{$job->created_at->format('m-d-Y')}}</span>
                            </li>
                        </ul>

                    </div>
                @empty
                    <p class="fs-5">No Listings Found</p>
                @endforelse

            </div>
        </div>
    </div>
</x-auth.authenticate>
