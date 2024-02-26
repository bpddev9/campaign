<div class="sing-out-screen-op">
    <span class="name">{{ auth()->user()->name }}</span>
    <div class="profile-photo">
        <a href="{{ $link }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Profile">
            <figure @if (is_null($profileImage)) class="no_img" @endif
                style="background-image: url({{ !is_null($profileImage) ? asset('storage/' . $profileImage) : asset('images/icon-user.svg') }});">
            </figure>
        </a>
    </div>
    <div class="sing-out">
        <a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sign out
        </a>
    </div>
</div>
