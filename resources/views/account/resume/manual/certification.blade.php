<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('resume.manual') }}"></a>
    </div>

    <div class="login-wapper scrool-extra">
        <h3 class="mb-4 py-2" style="font-size: 25px">Certification</h3>
        <form id="sing-up-form" action="{{ route('manual.certification.store') }}" method="POST" autocomplete="off">
            @csrf

            <input name="user_id" type="hidden" value="{{ auth()->user()->id }}">
            <input type="hidden" name="cert_id" value="{{isset($cert) ? $cert->id : ''}}">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="certificate" type="text" value="{{ old('certificate') ? old('certificate') : (isset($cert) && !is_null($cert->certificate) ? $cert->certificate : '') }}"
                                placeholder="Enter Certificate*">
                        </label>
                        @error('certificate')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="award_org" type="text" value="{{ old('award_org') ? old('award_org') : (isset($cert) && !is_null($cert->award_org) ? $cert->award_org : '') }}" placeholder="Organization*">
                        </label>
                        @error('award_org')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="wapper-form mb-2">
                        <label id="text-area" for="">
                            <textarea id="" name="summary" placeholder="Summary*" rows="3">{{ old('summary') ? old('summary') : (isset($cert) && !is_null($cert->summary) ? $cert->summary : '') }}</textarea>
                        </label>
                        @error('summary')
                            <small class="error-message" style="bottom: -20px;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12 mt-3 mb-3">
                    <div class="wapper-form">
                        <select class="email-label-new" id="" name="start_year">
                            <option value="">{{ Str::title('select start year*') }}</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{isset($cert) && $cert->start_year == $year ? 'selected' : ''}}>{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('start_year')
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
            @foreach ($certs as $cert)
                <div class="fst-sec">
                    <h6>{{ $cert->certificate }}</h6>
                    <p>{{ $cert->award_org }}</p>
                    <ul>
                        <li>
                           From: {{$cert->start_year}}
                        </li>
                        <li>
                            {{Str::limit($cert->summary, 80, '...')}}
                        </li>
                        <li class="edit_delete">
                            <a href="{{route('manual.certification.edit', $cert->id)}}">Edit</a>
                            <a href="{{route('manual.certification.delete', $cert->id)}}">Delete</a>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</x-auth.authenticate>