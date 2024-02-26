<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('my.account') }}"></a>
    </div>
    <div class="login-wapper">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <h5>Manage your jobs</h5>
        <ul>
            <li><a href="{{ route('jobs.index') }}">View Job Listings</a></li>
            <li><a href="{{ route('jobs.create') }}">Create new job</a></li>
        </ul>
    </div>
</x-auth.authenticate>