<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <ul>
            <li><a href="{{ route('resume.upload') }}">Upload Resume</a></li>
            <li><a href="{{ route('resume.manual') }}">Manual Enter Resume</a></li>
        </ul>
    </div>
</x-auth.authenticate>
