<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('resume.manual') }}"></a>
    </div>

    <div class="login-wapper scrool-extra">
        <h3 class="mb-4 py-2" style="font-size: 25px">Publication</h3>
        <form id="sing-up-form" action="{{ route('manual.publication.store') }}" method="POST" autocomplete="off">
            @csrf

            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
            <input type="hidden" name="pub_id" value="{{isset($pub) ? $pub->id : ''}}">

            <div class="row">
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="title" type="text" value="{{ old('title') ? old('title') : (isset($pub) && !is_null($pub->title) ? $pub->title : '') }}"
                                placeholder="Title*">
                        </label>
                        @error('title')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="publisher" type="text" value="{{ old('publisher') ? old('publisher') : (isset($pub) && !is_null($pub->publisher) ? $pub->publisher : '') }}" placeholder="Publisher*">
                        </label>
                        @error('publisher')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="wapper-form mb-2">
                        <label id="text-area" for="">
                            <textarea id="" name="summary" placeholder="Summary*" rows="3">{{ old('summary') ? old('summary') : (isset($pub) && !is_null($pub->summary) ? $pub->summary : '') }}</textarea>
                        </label>
                        @error('summary')
                            <small class="error-message" style="bottom: -20px;">{{ $message }}</small>
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
            @foreach ($pubs as $pub)
                <div class="fst-sec">
                    <h6>{{ $pub->title }}</h6>
                    <p>{{ $pub->publisher }}</p>
                    <ul>
                        <li>
                            {{Str::limit($pub->summary, 80, '...')}}
                        </li>
                        <li class="edit_delete">
                            <a href="{{route('manual.publication.edit', $pub->id)}}">Edit</a>
                            <a href="{{route('manual.publication.delete', $pub->id)}}">Delete</a>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

</x-auth.authenticate>
