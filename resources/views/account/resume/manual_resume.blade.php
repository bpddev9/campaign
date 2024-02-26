<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('manage.resume') }}"></a>
    </div>
    <div>
        <div class="login-wapper">
            <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
            <ul>
                <li><a href="{{ route('manual.work-experience') }}">Add Work Experience</a></li>
                <li><a href="{{ route('manual.education') }}">Add Education</a></li>
                <li><a href="{{ route('manual.certification') }}">Add Certification</a></li>
                <li><a href="{{ route('manual.publication') }}">Add Publications</a></li>
                <li><a href="{{ route('manual.award') }}">Add Awards</a></li>
                <li><a href="{{ route('manual.links') }}">Add Links</a></li>
                <li><a href="{{ route('applicant.view.profile') }}">View Resume Details</a></li>
            </ul>
        </div>
    </div>
</x-auth.authenticate>
