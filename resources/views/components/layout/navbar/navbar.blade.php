{{-- Top navbar --}}
{{-- TODO: Make the basic navbar markup --}}

<nav class="{{ $makeNavbarClasses() }}">
    <div class="container-fluid">

        {{-- Start links --}}

        <ul class="navbar-nav">

            {{-- TODO: Create a general navbar-link component and use the component --}}
            {{-- TODO: Included items should be readed from a config file --}}
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </li>

            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link">Home</a>
            </li>

            <li class="nav-item d-none d-md-block">
                <a href="#" class="nav-link">Contact</a>
            </li>

        </ul>

        {{-- End links --}}

        <ul class="navbar-nav ms-auto">

            {{-- TODO: Navbar search (navbar-search) should be also a component --}}
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fa-solid fa-search"></i>
                </a>
            </li>

        </ul>

    </div>
</nav>
