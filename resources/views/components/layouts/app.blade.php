<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    @include('partials._toast_msg')

    @include('campaign.jobs.partials._toast')

    {{-- @if (request()->segment(1)) --}}
        @if (!(Route::is('authenticate') || Route::is('reset.view')))
            @include('partials._app_header')
        @endif
    {{-- @endif --}}

    {{ $slot }}

    @include('partials._app_footer')

    @stack('scripts')
    <script defer>
        document.addEventListener('DOMContentLoaded', function(e) {
            const toastElemnt = document.querySelector('.toast')
            let successMsg = "{{ session()->get('success') }}"

            if (toastElemnt && successMsg != "") {
                window.MyToast.show()
            }
        })
    </script>
</body>

</html>
