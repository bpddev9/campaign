<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('resume.manual') }}"></a>
    </div>

    <div class="login-wapper scrool-extra">
        <h3 class="mb-4 py-2" style="font-size: 25px">Awards</h3>
        <form id="sing-up-form" action="{{ route('manual.award.store') }}" method="POST" autocomplete="off">
            @csrf
            
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
            <input type="hidden" name="award_id" value="{{isset($award) ? $award->id : ''}}">

            <div class="row">
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="award" type="text" value="{{ old('award') ? old('award') : (isset($award) && !is_null($award->certificate) ? $award->certificate : '') }}"
                                placeholder="Enter Award*">
                        </label>
                        @error('award')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="award_org" type="text" value="{{ old('award_org') ? old('award_org') : (isset($award) && !is_null($award->award_org) ? $award->award_org : '') }}" placeholder="Organisation*">
                        </label>
                        @error('award_org')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="wapper-form mb-2">
                        <label id="text-area" for="">
                            <textarea id="" name="summary" placeholder="Summary*" rows="3">{{ old('summary') ? old('summary') : (isset($award) && !is_null($award->summary) ? $award->summary : '') }}</textarea>
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
                                <option value="{{ $year }}" {{isset($award) && $award->start_year == $year ? 'selected' : ''}}>{{ $year }}</option>
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
            @foreach ($awards as $award)
                <div class="fst-sec">
                    <h6>{{ $award->certificate }}</h6>
                    <p>{{ $award->award_org }}</p>
                    <ul>
                        <li>
                            From: {{$award->start_year}}
                        </li>
                        <li>
                            {{Str::limit($award->summary, 80, '...')}}
                        </li>
                        <li class="edit_delete">
                            <a href="{{route('manual.award.edit', $award->id)}}">Edit</a>
                            <a href="{{route('manual.award.delete', $award->id)}}">Delete</a>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

</x-auth.authenticate>
