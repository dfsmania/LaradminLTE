{{-- Standard favicon (fallback for older browsers) --}}
<link rel="icon" type="image/x-icon" href="{{ asset('favicons/favicon.ico') }}">

@if($fullSupport)
    {{-- PNG icons (most modern browsers) --}}
    @foreach($pngSizes as $size)
        <link rel="icon" type="image/png" sizes="{{ $size }}" href="{{ asset("favicons/favicon-{$size}.png") }}">
    @endforeach

    {{-- Apple Touch Icon (iOS, Safari, used for home screen icon on iOS devices) --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">

    {{-- Web App Manifest (PWA support) --}}
    <link rel="manifest" href="{{ asset('favicons/site.webmanifest') }}">

    {{-- Safari pinned tab icon (macOS) --}}
    <link rel="mask-icon" href="{{ asset('favicons/safari-pinned-tab.svg') }}" color="{{ $brandLogoColor }}">

    {{-- Windows tiles --}}
    <meta name="msapplication-TileColor" content="{{ $brandBackgroundColor }}">
    <meta name="msapplication-TileImage" content="{{ asset('favicons/mstile-144x144.png') }}">

    {{-- Sets the browser's address bar color (for mobile browsers like Chrome) --}}
    <meta name="theme-color" content="{{ $brandBackgroundColor }}">
@endif
