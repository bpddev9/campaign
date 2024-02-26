<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('resume.manual') }}"></a>
    </div>

    <div class="login-wapper scrool-extra">
        <h3 class="mb-4 py-2" style="font-size: 25px">Education</h3>
        <form id="sing-up-form" action="{{ route('manual.education.store') }}" method="POST" autocomplete="off">
            @csrf

            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="qualification_id" value="{{isset($edu) ? $edu->id : ''}}">
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="institute_name" type="text" value="{{ old('institute_name') ? old('institute_name') : (isset($edu) && !is_null($edu->institute_name) ? $edu->institute_name : '') }}"
                                placeholder="Institute Name*">
                        </label>
                        @error('institute_name')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="degree" type="text" value="{{ old('degree') ? old('degree') : (isset($edu) && !is_null($edu->degree) ? $edu->degree : '') }}" placeholder="Degree*">
                        </label>
                        @error('degree')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="wapper-form">
                        <select class="email-label-new" id="" name="start_year">
                            <option value="">{{ Str::title('select start year*') }}</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{isset($edu) && $edu->start_year == $year ? 'selected' : ''}}>{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('start_year')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="wapper-form">
                        <select class="email-label-new" id="" name="end_year">
                            <option value="">{{ Str::title('select End year*') }}</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{isset($edu) && $edu->end_year == $year ? 'selected' : ''}}>{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('end_year')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
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
            @foreach ($edus as $edu)
                <div class="fst-sec">
                    <h6>{{ $edu->institute_name }}</h6>
                    <p>{{ $edu->degree }}</p>
                    <ul>
                        <li>
                            From: {{$edu->start_year}}
                        </li>
                        <li>
                            To: {{$edu->end_year}}
                        </li>
                        <li class="edit_delete">
                            <a href="{{route('manual.education.edit', $edu->id)}}">Edit</a>
                            <a href="{{route('manual.education.delete', $edu->id)}}">Delete</a>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

</x-auth.authenticate>
