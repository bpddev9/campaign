<x-auth.authenticate>
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    @endpush

    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper form-element">
        <h2>{{ $user->role === 'applicant' ? __('Applicant') : __('Campaign') }}</h2>
        <p class="fs-4 text-uppercase fw-bold text-white">{{ __('My Profile') }}</p>

        <div class="search-result-main" style="text-align: left; margin-top: 40px;">
            <div class="text profile-main-wapper my-3 rounded border p-3 text-white">
                <h5>
                    Basic Info
                    <span class="ms-3">
                        <a href="{{ route('my.profile') }}" title="Edit">
                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                        </a>
                    </span>
                </h5>
                <hr>
                <div class="d-flex my-2">
                    <div class="text-capitalize flex-shrink-0">
                        <span class="profile-label">Name:</span>
                    </div>
                    <div class="flex-grow-1 fw-bold ms-3">
                        <span class="profile-dtl">{{ $user->name }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="text-capitalize flex-shrink-0">
                        <span class="profile-label">Email:</span>
                    </div>
                    <div class="flex-grow-1 fw-bold ms-3">
                        <span class="profile-dtl">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="text-capitalize flex-shrink-0">
                        <span class="profile-label">Phone:</span>
                    </div>
                    <div class="flex-grow-1 fw-bold ms-3">
                        <span class="profile-dtl">{{ $user->phone_no }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="text-capitalize flex-shrink-0">
                        <span class="profile-label">Address:</span>
                    </div>
                    <div class="flex-grow-1 fw-bold ms-3">
                        <span class="profile-dtl">{{ optional($user->profile)->street_address ?: 'N/a' }}</span>
                    </div>
                </div>
                <div class="d-flex my-2">
                    <div class="text-capitalize flex-shrink-0">
                        <span class="profile-label">Political Group:</span>
                    </div>
                    <div class="flex-grow-1 fw-bold ms-3">
                        <span class="profile-dtl">{{ $user->political_group ?: 'N/a' }}</span>
                    </div>
                </div>
            </div>
            {{-- <div class="text border p-3 my-3 rounded text-white profile-main-wapper">
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
                            <p>N/a</p>
                        @endif
                    </div>
                </div>
            </div> --}}
            <div class="text profile-main-wapper my-3 rounded border p-3 text-white">
                <h5>
                    Resume Details
                    <span class="ms-3">
                        <a href="{{ route('resume.manual') }}" title="Edit">
                            <i class="fa fa-pencil-square" aria-hidden="true"></i>
                        </a>
                    </span>
                </h5>
                <hr>
                @if (!is_null($user->qualifications) && $user->qualifications->count())
                    <div class="mt-3">
                        <p class="lead fw-bold">Educational Qualification</p>
                        @foreach ($user->qualifications as $item)
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Institute Name:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->institute_name }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Degree:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->degree }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">From:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->start_year }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">To:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->end_year }}</span>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                    <hr>
                @endif

                @if (!is_null($user->workExperiences) && $user->workExperiences->count())
                    <div class="mt-3">
                        <p class="lead fw-bold">Work Experience</p>
                        @foreach ($user->workExperiences as $item)
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Job Title:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->title }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Organization:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->company_name }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">From:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ Carbon\Carbon::parse($item->start_date)->format('j M, Y') }}</span>
                                </div>
                            </div>
                            @if ($item->end_date != null)
                                <div class="d-flex my-2">
                                    <div class="text-capitalize flex-shrink-0">
                                        <span class="profile-label">To:</span>
                                    </div>
                                    <div class="flex-grow-1 fw-bold ms-3">
                                        <span class="profile-dtl">{{ Carbon\Carbon::parse($item->end_date)->format('j M, Y') }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Description:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->description }}</span>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                    <hr>
                @endif

                @if (!is_null($user->publications) && $user->publications->count())
                    <div class="mt-3">
                        <p class="lead fw-bold">Publications</p>
                        @foreach ($user->publications as $item)
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Title:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->title }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Publisher:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->publisher }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Summary:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->summary }}</span>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                    <hr>
                @endif

                @if (!is_null($certifications) && $certifications->count())
                    <div class="mt-3">
                        <p class="lead fw-bold">Certifications</p>
                        @foreach ($certifications as $item)
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Certificate Name:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->certificate }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Certificate Organization:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->award_org }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Summary:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->summary }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">From:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->start_year }}</span>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                    <hr>
                @endif

                @if (!is_null($awards) && $awards->count())
                    <div class="mt-3">
                        <p class="lead fw-bold">Awards</p>
                        @foreach ($awards as $item)
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Award Name:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->certificate }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Award Organization:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->award_org }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">Summary:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->summary }}</span>
                                </div>
                            </div>
                            <div class="d-flex my-2">
                                <div class="text-capitalize flex-shrink-0">
                                    <span class="profile-label">From:</span>
                                </div>
                                <div class="flex-grow-1 fw-bold ms-3">
                                    <span class="profile-dtl">{{ $item->start_year }}</span>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                    <hr>
                @endif
            </div>
        </div>
    </div>
</x-auth.authenticate>
