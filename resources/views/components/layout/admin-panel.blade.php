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

        {{-- TODO: This should be optional for scenarios without internet --}}
        {{-- Google Font: Source Sans Pro --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">

        {{-- TODO: What's the best way to include this --}}
        {{-- Overlayscrollbars --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/styles/overlayscrollbars.min.css" integrity="sha256-LWLZPJ7X1jJLI5OG5695qDemW1qQ7lNdbTfQ64ylbUY=" crossorigin="anonymous">

        {{-- TODO: What's the best way to include this --}}
        {{-- Fontawesome-free --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/css/all.min.css" integrity="sha256-/4UQcSmErDzPCMAiuOiWPVVsNN2s3ZY/NsmXNcj0IFc=" crossorigin="anonymous">

        {{-- TODO: Here we may include a component with the configured CSS plugins (pre AdminLte) --}}

        {{-- AdminLte theme style --}}
        <link rel="stylesheet" href="{{ $makeAdminlteHref() }}">

        {{-- TODO: Here we may include a component with the configured CSS plugins (post AdminLte) --}}

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

        {{-- Overlayscrollbars --}}
        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.1.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-NRZchBuHZWSXldqrtAOeCZpucH/1n1ToJ3C8mSK95NU=" crossorigin="anonymous"></script>

        {{-- @Popperjs for Bootstrap 5 --}}
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>

        {{-- Bootstrap 5 --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

        {{-- TODO: Here we may include a component with the configured plugins scripts (pre AdminLte) --}}

        {{-- AdminLle App --}}
        <script src="{{ asset('vendor/laralive-admin/js/adminlte.min.js') }}"></script>

        {{-- TODO: Here we may include a component with the configured plugins scripts (post AdminLte) --}}

    </body>
</html>
