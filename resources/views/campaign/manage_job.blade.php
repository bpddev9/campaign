<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <h5></h5>
        <ul>
            <li><a href="{{ route('company.profile') }}">Manage Profile</a></li>
            <li><a href="{{ route('jobs.menu') }}">Jobs</a></li>
        </ul>
    </div>
</x-auth.authenticate>
