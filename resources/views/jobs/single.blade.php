<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('jobs.listing') }}"></a>
    </div>

    <div class="position-relative" aria-live="polite" aria-atomic="true">
        <div class="toast-container position-absolute start-50 translate-middle-x top-0 p-3">
            <div class="toast align-items-center bg-success border-0 text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button class="btn-close m-auto me-2" data-bs-dismiss="toast" type="button" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <div class="login-wapper scrool-extra">
        <div class="job-dtl">
            <h2>Applicant</h2>
            <div class="main-wapper_extra">
                <h3>{{ $employ->job_title }}</h3>
                <p>{{ $employ->user->companyProfile->company_name }}</p>
                <ul>
                    <li>
                        <span><img src="img/Icon-Calendar.svg" alt=""></span>
                        Type: {{ $employ->job_type }}
                    </li>
                    <li>
                        <span><img src="img/Icon-Location.svg" alt=""></span>
                        Location: {{ $employ->location_type }}
                    </li>
                    <li>
                        <span><img src="img/Icon-Location.svg" alt=""></span>
                        Employees: {{ $employ->no_of_people }}
                    </li>
                    <li>
                        <span><img src="img/Icon-Location.svg" alt=""></span>
                        Schedule: {{ $employ->job_schedule }}
                    </li>
                    <li>
                        <span><img src="img/Icon-Salary.svg" alt=""></span>
                        Salary: ${{ $employ->min_salary }} to ${{ $employ->max_salary }} {{ $employ->pay_rate }}
                    </li>
                    @if ($employ->can_call == 1)
                        <li>
                            <span><img src="img/Icon-Salary.svg" alt=""></span>
                            Phone: {{ $employ->user->phone_no }}
                        </li>
                    @endif

                    <li>
                        <span><img src="img/Icon-Salary.svg" alt=""></span>
                        Resume: {{ $employ->can_post_resume == 1 ? 'Can Post' : "Can't Post" }}
                    </li>

                    <li>
                        <span><img src="img/Icon-Salary.svg" alt=""></span>
                        @if (is_null($pivot))
                            Be the first to apply
                        @else
                            Applied:
                            @if ($pivot->user_id == auth()->id())
                                @if ($pivot->user_count > 1)
                                    You and {{ $pivot->user_count - 1 }} others have applied
                                @else
                                    Only you have applied
                                @endif
                            @else
                                {{ $pivot->user_count }} have applied
                            @endif
                        @endif
                    </li>
                </ul>
            </div>
            <div class="main-wapper_extra">
                <div class="wapper">
                    <h3>Jobs Description</h3>
                    <p>{{ $employ->job_description }}</p>
                </div>

                <div class="main-wapper_last">
                    @if (is_null($pivot))
                        <button class="sing-up-submit-in" id="sing-up-submit" data-bs-toggle="modal" data-bs-target="#myModal" type="button">
                            Apply Now
                        </button>
                    @else
                        <h4 style="color: rgb(110, 105, 110)">
                            You have already applied
                        </h4>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @if (is_null($pivot))
        <x-my-modal>
            <form id="profile-modal-form" action="" method="post" enctype="multipart/form-data">
                <div class="form-fields">
                    <input id="jobid" name="jobid" type="hidden" value="{{ $employ->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="name">Full Name</label>
                                <input class="form-control" id="name" name="name" type="text" value="{{ auth()->user()->name }}">
                                <small class="text-danger text-sm" id="nameError"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="text" value="{{ auth()->user()->email }}">
                                <small class="text-danger text-sm" id="emailError"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="phone_no">Phone Number</label>
                                <input class="form-control" id="phone_no" name="phone_no" type="text" value="{{ auth()->user()->phone_no }}">
                                <small class="text-danger text-sm" id="phoneError"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="street_address">Address</label>
                                <input class="form-control" id="street_address" name="street_address" type="text"
                                    value="{{ optional(auth()->user()->profile)->street_address }}">
                                <small class="text-danger text-sm" id="addressError"></small>
                            </div>
                        </div>
                    </div>

                    @if ($employ->can_post_resume)
                        <div class="mb-3">
                            <label class="form-label" for="resume_upload">Upload Resume (Only PDF, DOCX files are
                                allowed)</label>
                            <input class="form-control" id="resume_upload" type="file"
                                accept="application/msword, application/pdf, text/plain">
                            <small class="help-text text-muted">{{ optional(auth()->user()->resume)->file_name }}</small>
                            <small class="text-danger text-sm" id="fileError"></small>
                        </div>
                    @endif

                    @if (!is_null($questions))
                        <div class="normal-wapper">
                            <h4>Answer the below questions:</h4>
                            <hr>
                            <div class="row mt-4">
                                @foreach ($questions as $question)
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="question_{{ $question->sl_no }}">{{ $question->quest }}</label>
                                            <textarea class="rounded-3" id="question_{{ $question->sl_no }}" name="answer[]" data-serial="{{ $question->sl_no }}" rows="2" required></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-button">
                    <button class="btn" id="confirmBtn" type="submit">Confirm </button>
                    <button class="btn cancel" id="cancelBtn" data-bs-dismiss="modal" type="button">Cancel</button>
                </div>
            </form>
        </x-my-modal>
    @endif

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let modalElement = document.querySelector('#myModal')
                let modalFormElm = document.querySelector('#profile-modal-form')
                let cancelBtnElm = document.querySelector('#cancelBtn')
                let myToast = window.MyToast
                let resumeFile = null
                const formData = new FormData()
                const answerElements = Array.from(document.querySelectorAll('textarea[name="answer[]"]'))

                if (modalElement) {
                    document.querySelector('.modal-title').innerText = "Preview Profile"

                    modalElement.addEventListener('shown.bs.modal', function(e) {
                        $('#name').val()
                    })
                }


                // File Input Event
                $('#resume_upload').change(function(e) {
                    resumeFile = e.target.files[0]
                    $('.help-text').text('')
                })

                // Modal form submission
                $('#confirmBtn').click(function(event) {
                    event.preventDefault();

                    if (answerElements.length) {
                        answerElements.forEach(element => {
                            formData.append('answer[]', element.value)
                        })
                    }

                    var name = $('#name').val();
                    var email = $('#email').val();
                    var phone_no = $('#phone_no').val();
                    var street_address = $('#street_address').val();
                    var jobid = $('#jobid').val();

                    formData.append('name', name)
                    formData.append('email', email)
                    formData.append('phone_no', phone_no)
                    formData.append('street_address', street_address)
                    formData.append('jobid', jobid)
                    formData.append('resume_file', resumeFile)

                    cancelBtnElm.classList.add('d-none')
                    $(this).text('Loading...')
                    $(this).attr('disabled', 'disabled')
                    $('.form-fields').addClass('opacity-25')

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })

                    $.ajax({
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        url: '/my-account/confirm',
                        data: formData,
                        success: function(response) {
                            cancelBtnElm.classList.remove('d-none')
                            $(this).text('Confirm')
                            $(this).removeAttr('disabled')
                            $('.form-fields').removeClass('opacity-25')
                            $('#myModal').modal('hide');
                            $('.main-wapper_last').remove();
                            document.querySelector('.toast-body').innerText = response.message
                            myToast.show()
                        },
                        error: function(error) {
                            $('.form-fields').removeClass('opacity-25')
                            cancelBtnElm.classList.remove('d-none')
                            $('#confirmBtn').text('Confirm')
                            $('#confirmBtn').removeAttr('disabled', 'disabled')

                            $('#nameError').text(error.responseJSON.errors.name);
                            $('#phoneError').text(error.responseJSON.errors.phone_no);
                            $('#emailError').text(error.responseJSON.errors.email);
                            $('#addressError').text(error.responseJSON.errors.street_address);
                            $('#fileError').text(error.responseJSON.errors.resume_file);
                        }
                    })
                });
            })
        </script>
    @endpush
</x-auth.authenticate>
