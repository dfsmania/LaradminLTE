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
        @foreach(ladmin()->plugins->getPreAdminlteLinks() as $resource)
            {{ $resource->renderToHtml() }}
        @endforeach

        {{-- AdminLTE theme style --}}
        <link rel="stylesheet" href="{{ $adminlteCssFile }}">

        {{-- Post AdminLTE plugins links --}}
        @foreach(ladmin()->plugins->getPostAdminlteLinks() as $resource)
            {{ $resource->renderToHtml() }}
        @endforeach

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
        @foreach(ladmin()->plugins->getPreAdminlteScripts() as $resource)
            {{ $resource->renderToHtml() }}
        @endforeach

        {{-- AdminLTE JavaScript App --}}
        <script src="{{ asset('vendor/ladmin/js/adminlte.min.js') }}"></script>

        {{-- Post AdminLTE plugins scripts --}}
        @foreach(ladmin()->plugins->getPostAdminlteScripts() as $resource)
            {{ $resource->renderToHtml() }}
        @endforeach

        {{-- OverlayScrollbars plugin initialization script --}}
        <x-ladmin-os-init/>

    </body>

</html>
