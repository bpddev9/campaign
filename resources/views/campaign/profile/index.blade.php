<x-auth.authenticate>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @endpush
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper form-element">
        <h2>{{ $user->role === 'applicant' ? __('Applicant') : __('Campaign') }}</h2>
        <p class="fs-4 text-uppercase fw-bold text-white">{{ __('Company Profile') }}</p>

        <div class="search-result-main" style="text-align: left; margin-top: 40px;">
            <div class="text border p-3 my-3 rounded text-white">
                <h5>
                    Basic Info
                    <span class="ms-3">
                        <a href="{{ route('company.profile') }}" title="Edit">
                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                        </a>
                    </span>
                </h5>
                <hr>
                <div class="d-flex my-2">
                    <div class="flex-shrink-0 text-capitalize">
                        <span class="profile-label">Name:</span>
                    </div>
                    <div class="flex-grow-1 ms-3 fw-bold text-capitalize">
                        <span class="profile-dtl">{{ $user->name }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="flex-shrink-0 text-capitalize">
                        <span class="profile-label">Company Name:</span>
                    </div>
                    <div class="flex-grow-1 ms-3 fw-bold text-capitalize">
                        <span class="profile-dtl">{{ optional($user->companyProfile)->company_name ?: 'N/a' }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="flex-shrink-0 text-capitalize">
                        <span class="profile-label">Political Group:</span>
                    </div>
                    <div class="flex-grow-1 ms-3 fw-bold text-capitalize">
                        <span class="profile-dtl">{{ $user->political_group ?: 'N/a' }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="flex-shrink-0 text-capitalize">
                        <span class="profile-label">street address:</span>
                    </div>
                    <div class="flex-grow-1 ms-3 fw-bold text-capitalize">
                        <span class="profile-dtl">{{ optional($user->companyProfile)->street_address ?: 'N/a' }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="flex-shrink-0 text-capitalize">
                        <span class="profile-label">city:</span>
                    </div>
                    <div class="flex-grow-1 ms-3 fw-bold text-capitalize">
                        <span class="profile-dtl">{{ optional($user->companyProfile)->city ?: 'N/a' }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="flex-shrink-0 text-capitalize">
                        <span class="profile-label">State:</span>
                    </div>
                    <div class="flex-grow-1 ms-3 fw-bold text-capitalize">
                        <span class="profile-dtl">{{ optional($user->companyProfile)->state ?: 'N/a' }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- <div class="search-result-main" style="text-align: left; margin-top: 40px;">
            <div class="text border p-3 my-3 rounded text-white">
                <h5>
                    Profile Questions
                    <span class="ms-3">
                        <a href="{{ route('profile.question') }}" title="Edit">
                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                        </a>
                    </span>
                </h5>
                <hr>

                <div class="question-area-wapper">
                    <div class="row gy-3">
                        @if (is_array($profileQs) && count($profileQs))
                            @foreach ($questions as $key => $question)    
                                <div class="col-lg-12">
                                    <span>{{ $question }}</span>
                                    <p class="fs-6 mt-2">{{ $profileQs[$key - 1]['answer'] }}</p>
                                </div>
                            @endforeach
                        @else
                        <div class="col-lg-12">
                            <p>N/a</p>
                        </div>
                        @endif
                    </div>
                </div>
                
            </div>
        </div> --}}
    </div>
</x-auth.authenticate>