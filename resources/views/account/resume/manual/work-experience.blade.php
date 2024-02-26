<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('resume.manual') }}"></a>
    </div>

    <div class="login-wapper scrool-extra">
        <h3 class="mb-4 py-2" style="font-size: 25px">Work Experience</h3>
        <form id="sing-up-form" action="{{ route('manual.work-experience.store') }}" method="POST" autocomplete="off">
            @csrf

            <input name="user_id" type="hidden" value="{{ auth()->user()->id }}">
            <input type="hidden" name="work_id" value="{{isset($work) ? $work->id : ''}}">
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="title" type="text"
                                value="{{ old('title') ? old('title') : (isset($work) && !is_null($work->title) ? $work->title : '') }}"
                                placeholder="Institute Name*">
                        </label>
                        @error('title')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="company_name" type="text"
                                value="{{ old('company_name') ? old('company_name') : (isset($work) && !is_null($work->company_name) ? $work->company_name : '') }}"
                                placeholder="Company Name*">
                        </label>
                        @error('company_name')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="start_date" type="text"
                                value="{{ old('start_date') ? old('start_date') : (isset($work) && !is_null($work->start_date) ? $work->start_date : '') }}"
                                placeholder="Select Start Date*" onfocus="(this.type='date')">
                        </label>
                        @error('start_date')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" class="endDate" name="end_date" type="text"
                                value="{{ old('end_date') ? old('end_date') : (isset($work) && !is_null($work->end_date) ? $work->end_date : '') }}"
                                placeholder="Select End Date*" onfocus="(this.type='date')">
                        </label>
                        @error('end_date')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <input type="hidden" value="{{(isset($work) && $work->currently_working == 1) ? 1 : 0}}" name="currently_working" id="changeCheck">

                <div class="col-lg-12">
                    <div class="form-check my-2">
                        <input class="form-check-input" id="currentlyWorkig" {{(isset($work) && $work->currently_working == 1) ? 'checked' : ''}} type="checkbox">
                        <label class="form-check-label" for="currentlyWorking">
                            I'm currently working here
                        </label>
                    </div>
                    @error('currently_working')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-lg-12">
                    <div class="wapper-form my-2">
                        <label id="text-area" for="">
                            <textarea id="" name="description" placeholder="Describe your work experience" rows="3">{{ old('description') ? old('description') : (isset($work) && !is_null($work->description) ? $work->description : '') }}</textarea>
                        </label>
                    </div>
                </div>

                <div class="col-lg-12">
                    <button id="sing-up-submit" type="submit">Submit</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <span class="or">Added</span>
            </div>
        </div>
        <div class="text-extra">
            @foreach ($exps as $exp)
                <div class="fst-sec">
                    <h6>{{ $exp->title }}</h6>
                    <p>{{ $exp->company_name }}</p>
                    <ul>
                        <li>
                            From: {{ Carbon\Carbon::parse($exp->start_date)->format('m-d-Y') }}
                        </li>
                        <li>
                            {{ $exp->currently_working === 1 ? 'Currently Working' : 'To: ' . Carbon\Carbon::parse($exp->end_date)->format('m-d-Y') }}
                        </li>
                        <li>
                            {{ Str::limit($exp->description, 80, '...') }}
                        </li>
                        <li class="edit_delete">
                            <a href="{{ route('manual.work-experience.edit', $exp->id) }}">Edit</a>
                            <a href="{{ route('manual.work-experience.delete', $exp->id) }}">Delete</a>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')    
    <script>
        var checkBox = document.getElementById('currentlyWorkig')
        var endDateValue = document.querySelector('.endDate').value

        if (checkBox.checked) {
            document.querySelector('.endDate').setAttribute('disabled', 'disabled')
        }

        checkBox.onchange = function (e) {
            if (checkBox.checked) {
                document.querySelector('.endDate').setAttribute('disabled', 'disabled');
                document.getElementById('changeCheck').value = 1;
            } else {
                document.querySelector('.endDate').removeAttribute('disabled');
                document.getElementById('changeCheck').value = 0;
            }
            
            if (document.querySelector('.endDate').value !== "") {
                document.querySelector('.endDate').value = ""
            } else {
                document.querySelector('.endDate').value = endDateValue
            }
        }
    </script>
    @endpush
</x-auth.authenticate>
