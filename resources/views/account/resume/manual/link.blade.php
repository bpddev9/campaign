<x-auth.authenticate>
    <div class="arrow">
        <a href="{{ route('resume.manual') }}"></a>
    </div>
    <div class="login-wapper scrool-extra">
        <h3 class="mb-4 py-2" style="font-size: 25px">Links</h3>
        <form id="sing-up-form" action="{{ route('manual.links.store') }}" method="POST" autocomplete="off">
            <div class="row">
                @csrf
                <div class="col-lg-6">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="link_title" type="text" value="{{ old('link_title') ? old('link_title') : (isset($link) && !is_null($link->link_title) ? $link->link_title : '') }}"
                                placeholder="Link Title">
                        </label>
                        @error('link_title')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="wapper-form">
                        <label id="name-label" for="">
                            <input id="name" name="link_url" type="text" value="{{ old('link_url') ? old('link_url') : (isset($link) && !is_null($link->link_url) ? $link->link_url : '') }}" placeholder="Enter URL">
                        </label>
                        @error('link_url')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <input type="hidden" name="link_id" value="{{ $link->id ?? null }}">
                    <button id="sing-up-submit" type="submit">Submit</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <span class="or">All Links</span>
            </div>
        </div>
        <div class="text-extra">
            @foreach ($links as $link)
                <div class="fst-sec">
                    <p>
                        <a href="{{ $link->link_url }}" target="_blank">
                            {{ $link->link_title }}
                        </a>
                    </p>
                    <ul>
                        <li class="edit_delete">
                            <a href="{{ route('manual.links.edit', $link->id) }}">Edit</a>
                            <a href="{{ route('manual.links.destroy', $link->id) }}" onclick="deleteData(event)">Delete</a>
                        </li>
                    </ul>
                </div>
            @endforeach

            <form action="" method="post" id="delete-form" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function deleteData(event) {
                event.preventDefault();
                document.querySelector('#delete-form').action = event.target.href
                document.querySelector('#delete-form').submit()
            }
        </script>
    @endpush
</x-auth.authenticate>
