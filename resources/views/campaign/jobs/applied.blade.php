<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('jobs.index') }}"></a>
    </div>
    <div class="login-wapper search-result-main">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <div class="manin-wapper">
            <div class="heading">
                <h5>Applied Users</h5>
            </div>
            <div class="text">
                @foreach ($applies as $applied)
                    <div class="fst-sec">
                        <h3 style="color: #38b9b9;">{{ $applied->name }}</h3>
                        <ul>
                            <li>
                                Phone: {{$applied->phone_no}}
                            </li>
                            <li>
                                Email: {{$applied->email}}
                            </li>
                        </ul>
                        <ul>
                            <li>
                                Posted on: <span><img src="{{ asset('images/Icon-Calendar.svg') }}" alt=""></span>
                                {{ $applied->created_at->format('m-d-Y') }}
                            </li>
                        </ul>
                        <ul>
                            <li class="edit-and-delete">
                                <a class="extra-a" href="#">Resume</a>
                                <a class="extra-a" href="#">Answers</a>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            //
        </script>
    @endpush

</x-auth.authenticate>
