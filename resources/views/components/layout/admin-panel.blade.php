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
        <x-ladmin-plugins-links :resources="ladmin()->plugins->getPreAdminlteLinks()"/>

        {{-- AdminLTE theme style --}}
        <link rel="stylesheet" href="{{ $adminlteCssFile }}">

        {{-- Post AdminLTE plugins links --}}
        <x-ladmin-plugins-links :resources="ladmin()->plugins->getPostAdminlteLinks()"/>

        {{-- Favicons markup --}}
        <x-ladmin-favicons/>

    </head>

    <body class="{{ $bodyClasses }}">

        <div class="app-wrapper">

            {{-- Top navbar --}}
            <x-ladmin-navbar/>

            {{-- Sidebar --}}
            <x-ladmin-sidebar/>

            {{-- Main content --}}
            <x-ladmin-main-content>
                @isset($contentHeader)
                    <x-slot name="contentHeader">
                        {{ $contentHeader }}
                    </x-slot>
                @endisset

                {{ $slot }}
            </x-ladmin-main-content>

            {{-- Footer --}}
            <x-ladmin-footer>
                @isset($footer)
                    {{ $footer }}
                @endisset
            </x-ladmin-footer>

        </div>

        {{-- Pre AdminLTE plugins scripts --}}
        <x-ladmin-plugins-scripts :resources="ladmin()->plugins->getPreAdminlteScripts()"/>

        {{-- AdminLTE JavaScript App --}}
        <script src="{{ asset('vendor/laradmin/js/adminlte.min.js') }}"></script>

        {{-- Post AdminLTE plugins scripts --}}
        <x-ladmin-plugins-scripts :resources="ladmin()->plugins->getPostAdminlteScripts()"/>

    </body>

</html>
