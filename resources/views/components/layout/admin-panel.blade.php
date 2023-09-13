<!DOCTYPE html>
<html lang="{{ $makeHtmlLang() }}" dir="{{ $makeHtmlDir() }}">

    <head>

        {{-- Primary meta tags --}}
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="title" content="{{ $title }}">

        {{-- Title --}}
        <title>{{ $title }}</title>

        {{-- Pre AdminLTE plugins links --}}
        <x-ladmin-plugins-links :resources="$plugins->getPreAdminlteLinks()"/>

        {{-- AdminLte theme style --}}
        <link rel="stylesheet" href="{{ $makeAdminlteHref() }}">

        {{-- Post AdminLTE plugins links --}}
        <x-ladmin-plugins-links :resources="$plugins->getPostAdminlteLinks()"/>

        {{-- TODO: Add favicons markup --}}

    </head>

    {{-- TODO: Generate body data-*  attributes using a $makeBodyData() --}}
    <body class="{{ $makeBodyClasses() }}">

        <div class="app-wrapper">

            {{-- Top navbar --}}
            <x-ladmin-navbar/>

            {{-- Sidebar --}}
            <x-ladmin-sidebar/>

            {{-- Main content --}}
            <main class="app-main">

                {{-- TODO: Create a component for the Content Header --}}
                {{-- Content Header --}}
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            CONTENT HEADER
                        </div>
                    </div>
                </div>

                {{-- TODO: Create a component for the Content Body --}}
                {{-- Content Body --}}
                <div class="app-content">
                    <div class="container-fluid">
                        <div class="row">
                            CONTENT BODY
                            {{ $slot }}
                        </div>
                    </div>
                </div>

            </main>

            {{-- TODO: Create a component for the Footer? --}}
            {{-- Footer --}}
            <footer class="app-footer">
                <div class="float-end d-none d-sm-inline">
                    Anything you want
                </div>

                <strong>Copyright &copy; 2014-2023.</strong>
            </footer>

        </div>

        {{-- Pre AdminLTE plugins scripts --}}
        <x-ladmin-plugins-scripts :resources="$plugins->getPreAdminlteScripts()"/>

        {{-- AdminLte App --}}
        <script src="{{ asset('vendor/laralive-admin/js/adminlte.min.js') }}"></script>

        {{-- Post AdminLTE plugins scripts --}}
        <x-ladmin-plugins-scripts :resources="$plugins->getPostAdminlteScripts()"/>

    </body>
</html>
