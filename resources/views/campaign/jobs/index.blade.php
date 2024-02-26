<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('jobs.menu') }}"></a>
    </div>
    <div class="login-wapper search-result-main">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <div class="manin-wapper">
            <div class="heading">
                <h5>all jobs</h5>
            </div>
            <div class="text">
                @if (!$jobs->count())
                    <p class="lead fs-5 fw-bold text-warning">There isn't any jobs</p>
                @else
                    @foreach ($jobs as $job)
                        <div class="fst-sec">
                            <h3 style="color: #38b9b9;">{{ $job->job_title }}</h3>
                            <p>{{ Str::limit($job->job_description, 150) }}</p>
                            <ul>
                                <li>
                                    Posted on: <span><img src="{{ asset('images/Icon-Calendar.svg') }}" alt=""></span>
                                    {{ $job->created_at->format('m-d-Y') }}
                                </li>
                                @if ($job->users_count > 0)
                                    <li>
                                        Applied: {{ $job->users_count }} {{ $job->users_count > 1 ? Str::plural('User') : 'User' }}
                                    </li>
                                @endif
                            </ul>
                            <ul>
                                <li class="edit-and-delete">
                                    <a class="extra-a" href="{{ route('job.edit', $job) }}">Edit</a>
                                    <a class="extra-a" href="{{ route('job.destroy', $job) }}"
                                        onclick="event.preventDefault();
                                        var form = document.querySelector('#job-delete')
                                        form.setAttribute('action', this.getAttribute('href'))
                                        form.submit()">
                                        Delete
                                    </a>
                                    @if ($job->users_count > 0)
                                        <a class="extra-a" href="{{ route('job.applied', $job) }}">
                                            Applied Users</a>
                                    @endif

                                </li>
                            </ul>
                        </div>
                    @endforeach

                    <form id="job-delete" style="display: none;" action="" method="post">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toastElemnt = document.querySelector('.toast')

                if (sessionStorage.getItem('success')) {
                    let {
                        message
                    } = JSON.parse(sessionStorage.getItem('success'))
                    document.querySelector('.toast-body').innerText = message
                    window.MyToast.show()
                }

                toastElemnt.addEventListener('hidden.bs.toast', () => {
                    sessionStorage.removeItem('success')
                })
            })
        </script>
    @endpush

</x-auth.authenticate>
