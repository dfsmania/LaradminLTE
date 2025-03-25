{{-- Sidebar --}}
<aside class="{{ $makeSidebarClasses() }}" data-bs-theme="{{ $makeBootstrapTheme() }}">

    {{-- Sidebar brand --}}
    {{-- TODO: Properties should be read from configuration file --}}
    <x-ladmin-sidebar-brand label="AdminLTE"
        logo-url="{{ asset('vendor/laradmin/img/AdminLTELogo.png') }}"
        logo-alt="AdminLTE"
        label-classes="fw-bold"
        logo-classes="opacity-75 rounded-circle shadow-sm"/>

    {{-- Sidebar menu wrapper --}}
    <div class="sidebar-wrapper">
        <nav class="mt-2">

            {{-- Sidebar menu --}}
            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                data-accordion="false"
                role="menu">

                {{-- Basic Link tests --}}

                <x-ladmin-sidebar-header label="Basic Link Tests" icon="fa-regular fa-bookmark"
                    class="text-uppercase fw-bold" theme="success"/>

                <x-ladmin-sidebar-link label="Link 1" icon="fa-regular fa-circle"/>

                <x-ladmin-sidebar-link label="Link 2" icon="fa-regular fa-square" theme="warning"/>

                <x-ladmin-sidebar-link label="Link 3" icon="fa-regular fa-circle-dot"
                    badge="5" badge-theme="info"/>

                <x-ladmin-sidebar-link label="Link 4" icon="fa-solid fa-star" theme="info"
                    badge="7" badge-theme="danger" badge-classes="rounded-circle"/>

                {{-- Treeview menu tests --}}

                <x-ladmin-sidebar-header label="Treeview Menu Tests" icon="fa-regular fa-bookmark"
                    class="text-uppercase fw-bold" theme="success"/>

                <x-ladmin-sidebar-treeview label="Menu 1" icon="fa-solid fa-cubes">
                    <x-ladmin-sidebar-link label="Link A" icon="fa-regular fa-circle"/>
                    <x-ladmin-sidebar-link label="Link B" icon="fa-regular fa-circle"/>

                    <x-ladmin-sidebar-treeview label="Menu 2" icon="fa-solid fa-cubes"
                        theme="info" badge="2" badge-theme="warning">
                        <x-ladmin-sidebar-link label="Link C" icon="fa-regular fa-circle"/>
                        <x-ladmin-sidebar-link label="Link D" icon="fa-regular fa-circle"/>
                    </x-ladmin-sidebar-treeview>
                </x-ladmin-sidebar-treeview>

                <x-ladmin-sidebar-treeview label="Menu 3" icon="fa-solid fa-cubes"
                    theme="danger" badge="2" toggler-icon="fa-solid fa-caret-right">
                    <x-ladmin-sidebar-link label="Link E" icon="fa-regular fa-circle"/>
                    <x-ladmin-sidebar-link label="Link F" icon="fa-regular fa-circle"/>
                </x-ladmin-sidebar-treeview>

            </ul>

        </nav>
    </div>

</aside>
