<!DOCTYPE html>
<html lang="{{ $htmlLang }}" dir="{{ $htmlDir }}" data-bs-theme="{{ $bootstrapTheme }}">

    <head>

        {{-- Primary meta tags --}}
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="title" content="{{ $title }}">

        {{-- Title --}}
        <title>{{ $title }}</title>

        {{-- Pre AdminLTE plugins links --}}
        @foreach($preAdminlteLinks as $resource)
            {{ $resource->renderToHtml() }}
        @endforeach

        {{-- AdminLTE theme style --}}
        <link rel="stylesheet" href="{{ $adminlteCssFile }}">

        {{-- Favicons markup --}}
        <x-ladmin-favicons/>

        {{-- Inline CSS injected from child views using @push('css') --}}
        @stack('css')

    </head>

    <body class="{{ $bodyClasses }}" style="{{ $bodyStyles }}">

        {{-- Authentication box --}}
        <div class="login-box">
            {{-- Authentication logo --}}
            <x-ladmin-auth-logo/>

            {{-- Authentication content --}}
            {{ $slot }}
        </div>

        {{-- Pre AdminLTE plugins scripts --}}
        @foreach($preAdminlteScripts as $resource)
            {{ $resource->renderToHtml() }}
        @endforeach

        {{-- AdminLTE JavaScript App --}}
        <script src="{{ asset('vendor/ladmin/js/adminlte.min.js') }}"></script>

        {{-- Inline JavaScript injected from child views using @push('js') --}}
        @stack('js')

    </body>

</html>
