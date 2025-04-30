{{-- Top navbar --}}
<nav class="{{ $navbarClasses }}">
    <div class="container-fluid">

        {{-- Start links --}}
        <ul class="navbar-nav">
            @foreach(ladmin()->menu->getLeftNavbarItems() as $item)
                {{ $item->render() }}
            @endforeach
        </ul>

        {{-- End links --}}
        <ul class="navbar-nav ms-auto">
            @foreach(ladmin()->menu->getRightNavbarItems() as $item)
                {{ $item->render() }}
            @endforeach
        </ul>

    </div>
</nav>
