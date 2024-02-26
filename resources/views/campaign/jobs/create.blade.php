<x-auth.authenticate>
    @push('styles')
        <style>
            [x-cloak] {
                display: none;
            }
        </style>
    @endpush

    <div class="arrow">
        <a href="{{ route('jobs.menu') }}" id="back-btn"></a>
    </div>
    <div class="login-wapper" x-cloak x-data="{ ...state() }" x-init="jobRoles = {{ $jobRoles }}">
        <h2>{{ auth()->user()->role === 'applicant' ? 'Applicant' : 'Campaign' }}</h2>
        <h5 class="fs-6 text-capitalize">Follow the job creation wizard to add a new job</h5>
        <h5 x-text="`${$wizard.current().title}`"></h5>
        <form method="POST" id="password-form" x-ref="jobPost" x-on:submit.prevent="savePost">
            <div x-wizard:step="form.job_title != '' && form.job_position != '' && form.location_type != ''"
                x-wizard:title="Provide basic information">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label for="" id="" class="float-start mb-2 text-white text-capitalize">Industry</label>
                            <select x-model="form.job_title" class="email-label-new" x-on:change="roleSelected">
                                <option value="">Select...</option>
                                <template x-for="(role, index) in jobRoles.data" :key="index">
                                    <option x-bind:value="role.title" x-text="role.title"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="" id="" class="float-start mb-2 text-white text-capitalize">job
                            Title</label>
                        <select class="email-label-new" :class="!designations.length ? 'opacity-50' : ''"
                            x-model="form.job_position" x-on:change="positionSelected"
                            x-bind:disabled="!designations.length">
                            <option value="">Select...</option>
                            <template x-for="(item, index) in designations" :key="index">
                                <option x-bind:value="item" x-text="item"></option>
                            </template>
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <div class="wapper-form">
                            <label for="" id=""
                                class="float-start mb-2 text-white text-capitalize">Location Type</label>
                            <select x-model="form.location_type" class="email-label-new">
                                <option value="">Select...</option>
                                <option value="remote">Remote</option>
                                <option value="office">Office</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div x-wizard:step="form.job_type != '' && form.job_schedule != '' && form.no_of_people >= 1"
                x-wizard:title="Include Details">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label for="" id="" class="float-start mb-2 text-white text-capitalize">Type</label>
                            <select x-model="form.job_type" class="email-label-new">
                                <option value="">Select...</option>
                                @foreach ($jobTypes as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label for="" id="" class="float-start mb-2 text-white text-capitalize">Schedule</label>
                            <select x-model="form.job_schedule" class="email-label-new">
                                <option value="">Select...</option>
                                @foreach ($jobSchedules as $schedule)
                                    <option value="{{ $schedule }}">{{ $schedule }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="wapper-form">
                            <label for="" id=""
                                class="float-start mb-2 text-white text-capitalize">
                                Number of people you wish to hire
                            </label>
                            <input type="text" x-model="form.no_of_people" pattern="[0-9]+" class="email-label-new">
                        </div>
                    </div>
                </div>
            </div>
            <div x-wizard:step="form.min_salary != '' && form.pay_rate != '' && !max_salary_error"
                x-wizard:title="Add compensation">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label for="" id=""
                                class="float-start mb-2 text-white text-capitalize">minimum salary</label>
                            <input type="text" x-model.number="form.min_salary" class="email-label-new">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wapper-form">
                            <label for="" id=""
                                class="float-start mb-2 text-white text-capitalize">maximum salary</label>
                            <input type="text" x-model.number="form.max_salary" class="email-label-new">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="wapper-form">
                            <label for="" id=""
                                class="float-start mb-2 text-white text-capitalize">payment rate</label>
                            <select x-model="form.pay_rate" class="email-label-new">
                                <option value="">Select...</option>
                                @foreach ($payRates as $rate)
                                    <option value="{{ $rate }}">{{ Str::title($rate) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div x-wizard:step="form.job_description != ''" x-wizard:title="Describe the job">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wapper-form">
                            <label for="" id=""
                                class="float-start mb-2 text-white text-capitalize">Job description</label>
                            <textarea x-model="form.job_description" style="color: #a93434;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div x-wizard:step="form.can_call != '' || form.can_post_resume != ''" x-wizard:title="Set application preferences">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wapper-form">
                            <label for="" id=""
                                class="float-start mb-2 text-white text-capitalize">Do you want applicants to call you directly for this job?</label>
                            <select class="email-label-new" x-model="form.can_call">
                                <option value="">Select...</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="wapper-form">
                            <label for="" id=""
                                class="float-start mb-2 text-white text-capitalize">Do you want applicants to submit their resume?</label>
                            <select class="email-label-new" x-model="form.can_post_resume">
                                <option value="">Select...</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-between">
                <div class="col-2">
                    <button type="button" class="submit back-next" :class="$wizard.cannotGoBack() ? 'opacity-25' : ''"
                        x-bind:disabled="$wizard.cannotGoBack()" x-on:click="$wizard.back()">Back</button>
                </div>
                <div class="col-2">
                    <button type="button" class="submit back-next" x-bind:disabled="$wizard.cannotGoForward()"
                        x-on:click="$wizard.forward()" x-show="$wizard.isNotLast()"
                        :class="$wizard.cannotGoForward() ? 'opacity-25' : ''">Next</button>
                    <button type="submit" class="submit" x-bind:disabled="$wizard.isNotComplete()"
                        :class="$wizard.isNotComplete() ? 'opacity-25' : ''" x-show="$wizard.isLast()">Submit</button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/@glhd/alpine-wizard@1/dist/wizard.cdn.min.js"></script>
        <script>
            function state() {
                return {
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
                    max_salary_error: false,
                    jobRoles: null,
                    designations: [],
                    roleItem: null,

                    init() {
                        this.$watch('form.max_salary', (value) => {
                            this.max_salary_error = (value !== null && value <= this.form.min_salary) ? true : false
                        })

                        document.getElementById('back-btn').addEventListener('click', e => {
                            e.preventDefault()

                            if (this.$wizard.isNotFirst()) {
                                var c = confirm("Do you really wish to exit the job creation wizard?")
                                if (c) {
                                    window.location.href = "/my-account/job-menu"
                                }
                                return
                            }
                            window.location.href = "/my-account/job-menu"
                        })
                    },

                    roleSelected() {
                        if (this.form.job_title == '') {
                            this.designations = []
                            return
                        }
                        let roleItems = this.jobRoles.data.find(i => i.title === this.form.job_title)
                        this.roleItem = roleItems.details.map(i => i)
                        this.designations = roleItems.details.map((i) => i.position)
                    },

                    positionSelected() {
                        if (this.form.job_position == '') {
                            this.form.job_description = ''
                            return
                        }

                        let roleItem = this.roleItem.find(i => i.position === this.form.job_position)
                        this.form.job_description = roleItem.description
                    },

                    async savePost() {
                        try {
                            let response = await window.axios.post("{{ route('jobs.store') }}", this.form)
                            sessionStorage.setItem("success", JSON.stringify({
                                status: true,
                                message: 'Job posted successfully'
                            }));
                            window.location.href = '/my-account/my-jobs'
                        } catch (error) {
                            console.log(error);
                        }
                    },
                }
            }
        </script>
    @endpush
</x-auth.authenticate>
