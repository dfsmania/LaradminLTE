{{-- Top navbar --}}
<nav class="{{ $makeNavbarClasses() }}">
    <div class="container-fluid">

        {{-- Start links --}}
        <ul class="navbar-nav">

            {{-- Hamburger button --}}
            <x-ladmin-navbar-link icon="fa-solid fa-bars" role="button" data-lte-toggle="sidebar"/>

            {{-- TODO: Custom links should be read from a config file --}}
            <x-ladmin-navbar-link label="Home" theme="primary"/>
            <x-ladmin-navbar-link label="Contact" theme="success" id="contact-link"/>

        </ul>

        {{-- End links --}}
        <ul class="navbar-nav ms-auto">

            {{-- TODO: Custom links should be read from a config file --}}
            <x-ladmin-navbar-link icon="fa-regular fa-lg fa-bell" badge="5"
                badge-theme="info" badge-classes="border border-dark border-1 rounded-circle"/>
            <x-ladmin-navbar-link icon="fa-regular fa-lg fa-envelope" badge="7"
                badge-theme="danger" badge-classes="border border-dark border-1 rounded-circle animate__animated animate__infinite animate__flash animate__slower"/>

            {{-- Navbar search button --}}
            {{-- TODO: How to use this search button? Should we move to config also? --}}
            <x-ladmin-navbar-link icon="fa-solid fa-lg fa-search" role="button" data-widget="navbar-search"/>

        </ul>

    </div>
</nav>
