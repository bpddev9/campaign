<x-auth.authenticate>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            [x-cloak] {
                display: none;
            }
        </style>
    @endpush

    <div x-data="{ ...state() }" x-cloak x-init="setJobData({{ $job }});
        setFormData({{ $job }});
        jobRoles = {{ $jobRoles }};
        job = jobRoles.data.find(i => i.title == '{{ $job->job_title }}');
        designations = job.details.map(item => item.position);
        jobData = {{ $job }}"
    >
        <div class="arrow">
            <a href="{{ route('jobs.index') }}"></a>
        </div>
        <div class="login-wapper search-result-main" style="height: 60vh;">
            <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
            <div class="manin-wapper">
                <div class="heading">
                    <h5>Update job</h5>
                </div>
                <div class="text border p-3 my-3 rounded text-white">
                    <h5>
                        Basic Information
                        <span class="ms-3">
                            <a href="" x-on:click.prevent="openModal(1)" title="Edit"><i
                                    class="fa fa-pencil-square" aria-hidden="true"></i></a>
                        </span>
                    </h5>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">Industry:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold ammount-class" x-text="data.job_title"></div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">Job Title:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize ammount-class" x-text="data.job_position"></div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">Location type:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize ammount-class" x-text="data.location_type"></div>
                    </div>
                </div>
                <div class="text border p-3 my-3 rounded text-white">
                    <h5>
                        Other Details
                        <span class="ms-3">
                            <a href="" x-on:click.prevent="openModal(2)" title="Edit"><i
                                    class="fa fa-pencil-square" aria-hidden="true"></i></a>
                        </span>
                    </h5>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">Type:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize ammount-class" x-text="data.job_type"></div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">Schedule:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize ammount-class" x-text="data.job_schedule"></div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">No of people to hire:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize ammount-class" x-text="data.no_of_people"></div>
                    </div>
                </div>
                <div class="text border p-3 my-3 rounded text-white">
                    <h5>
                        Compensation
                        <span class="ms-3">
                            <a href="" x-on:click.prevent="openModal(3)" title="Edit"><i
                                    class="fa fa-pencil-square" aria-hidden="true"></i></a>
                        </span>
                    </h5>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">minimun salary:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize ammount-class" x-text="`$${data.min_salary}`"></div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">maximum salary:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize ammount-class" x-text="`$${data.max_salary}`"></div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">Payment Rate:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize  ammount-class" x-text="data.pay_rate"></div>
                    </div>
                </div>
                <div class="text border p-3 my-3 rounded text-white">
                    <h5>
                        Job Description
                        <span class="ms-3">
                            <a href="" x-on:click.prevent="openModal(4)" title="Edit"><i
                                    class="fa fa-pencil-square" aria-hidden="true"></i></a>
                        </span>
                    </h5>
                    <div x-text="data.job_description" class="job_description-extra"></div>
                </div>
                <div class="text border p-3 my-3 rounded text-white">
                    <h5>
                        Set Preferences
                        <span class="ms-3">
                            <a href="" x-on:click.prevent="openModal(5)" title="Edit"><i
                                    class="fa fa-pencil-square" aria-hidden="true"></i></a>
                        </span>
                    </h5>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">Want Applicants To Call You:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize yes-no"
                            x-text="data.can_call === 1 ? 'Yes' : 'No'"></div>
                    </div>
                    <div class="d-flex my-2">
                        <div class="flex-shrink-0 text-capitalize">
                            <span class="profile-label">Want Applicants To Submit resume:</span>
                        </div>
                        <div class="flex-grow-1 ms-3 fw-bold text-capitalize yes-no"
                            x-text="data.can_post_resume === 1 ? 'Yes' : 'No'"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Markup -->
        <x-edit-job-modal>
            <template x-if="step == 1">
                @include('campaign.jobs.partials.modal._basic_info')
            </template>
            <template x-if="step == 2">
                @include('campaign.jobs.partials.modal._other_details')
            </template>
            <template x-if="step == 3">
                @include('campaign.jobs.partials.modal._pay_scale')
            </template>
            <template x-if="step == 4">
                @include('campaign.jobs.partials.modal._description')
            </template>
            <template x-if="step == 5">
                @include('campaign.jobs.partials.modal._preference')
            </template>
        </x-edit-job-modal>
        <!-- Modal Markup -->
    </div>


    @push('scripts')
        <script>
            function state() {
                return {
                    data: {
                        job_title: '',
                        location_type: '',
                        job_type: '',
                        job_position: '',
                        job_schedule: '',
                        no_of_people: '',
                        min_salary: '',
                        max_salary: '',
                        pay_rate: '',
                        job_description: '',
                        can_call: '',
                        can_post_resume: '',
                    },
                    form: {
                        job_title: '',
                        location_type: '',
                        job_type: '',
                        job_position: '',
                        job_schedule: '',
                        no_of_people: '',
                        min_salary: '',
                        max_salary: '',
                        pay_rate: '',
                        job_description: '',
                        can_call: '',
                        can_post_resume: '',
                    },
                    step: null,
                    jobRoles: null,
                    jobData: null,
                    error: {},
                    roleItem: null,
                    designations: [],

                    init() {
                        const modalEl = document.getElementById('myModal')

                        modalEl.addEventListener('show.bs.modal', () => {
                            switch (this.step) {
                                case 1:
                                    document.querySelector('#myModalLabel').innerText = 'Edit Basic Information'
                                    break;
                                case 2:
                                    document.querySelector('#myModalLabel').innerText = 'Edit Other Details'
                                    break;
                                case 3:
                                    document.querySelector('#myModalLabel').innerText = 'Edit Compensation'
                                    break;
                                case 4:
                                    document.querySelector('#myModalLabel').innerText = 'Edit Job Description'
                                    break;
                                case 5:
                                    document.querySelector('#myModalLabel').innerText = 'Edit Preferences'
                                    break;
                                default:
                                    break;
                            }
                        })

                        modalEl.addEventListener('hidden.bs.modal', () => {
                            this.step = null

                            Object.keys(this.form).forEach((key) => {
                                this.form[key] = this.jobData[key]
                            })

                            document.querySelector('#myModalLabel').innerText = ''
                        })
                    },

                    setJobData(param) {
                        this.data.job_title = param.job_title
                        this.data.location_type = param.location_type
                        this.data.job_position = param.job_position
                        this.data.job_type = param.job_type
                        this.data.job_schedule = param.job_schedule
                        this.data.no_of_people = param.no_of_people
                        this.data.min_salary = param.min_salary
                        this.data.max_salary = param.max_salary
                        this.data.pay_rate = param.pay_rate
                        this.data.job_description = param.job_description
                        this.data.can_call = param.can_call
                        this.data.can_post_resume = param.can_post_resume
                    },

                    setFormData(param) {
                        this.form.job_title = param.job_title
                        this.form.location_type = param.location_type
                        this.form.job_position = param.job_position
                        this.form.job_type = param.job_type
                        this.form.job_schedule = param.job_schedule
                        this.form.no_of_people = param.no_of_people
                        this.form.min_salary = param.min_salary
                        this.form.max_salary = param.max_salary
                        this.form.pay_rate = param.pay_rate
                        this.form.job_description = param.job_description
                        this.form.can_call = param.can_call
                        this.form.can_post_resume = param.can_post_resume
                    },

                    openModal(param) {
                        this.step = param
                        window.myModal.show()
                    },

                    roleSelected() {
                        let roleItems = this.jobRoles.data.find(i => i.title === this.form.job_title)
                        this.roleItem = roleItems.details.map(i => i)
                        this.designations = roleItems.details.map((i) => i.position)
                        this.form.job_description = this.roleItem[0].description
                    },

                    positionSelected() {
                        let job = this.jobRoles.data.find(i => i.title == this.form.job_title);
                        this.form.job_description = job.details.find(i => i.position == this.form.job_position).description
                        console.log(this.form.job_description);
                    },

                    async saveData() {
                        let url = "{{ route('job.update', $job->id) }}"
                        try {
                            let response = await window.axios.patch(url, this.form)
                            this.jobData = response.data.data.job
                            this.data = this.jobData
                            this.form = response.data.data.job
                            window.myModal.hide()
                        } catch (error) {
                            this.error = error.response.data.errors
                        }
                    },
                }
            }
        </script>
    @endpush
</x-auth.authenticate>
