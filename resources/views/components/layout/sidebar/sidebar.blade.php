{{-- Sidebar --}}
<aside class="{{ $sidebarClasses }}" data-bs-theme="{{ $bootstrapTheme }}">

    {{-- Sidebar brand --}}
    <x-ladmin-sidebar-brand label="{{ config('ladmin.logo.text', 'AdminLTE') }}"
        logo-url="{{ config('ladmin.logo.image', '') }}"
        logo-alt="{{ config('ladmin.logo.image_alt', 'AdminLTE Logo') }}"
        label-classes="{{ $brandTextClasses }}"
        logo-classes="{{ $brandImageClasses }}"/>

    {{-- Sidebar menu wrapper --}}
    <div class="sidebar-wrapper">
        <nav class="mt-2">

            {{-- Sidebar menu --}}
            <ul class="nav sidebar-menu flex-column"
                data-accordion="{{ config('ladmin.sidebar.accordion', false) }}"
                data-lte-toggle="treeview"
                role="menu">

                {{-- Basic Link tests --}}

                <x-ladmin-sidebar-header label="Basic Link Tests" icon="fa-regular fa-bookmark"
                    class="text-uppercase fw-bold" color="success"/>

                <x-ladmin-sidebar-link label="Link 1" icon="fa-regular fa-circle"/>

                <x-ladmin-sidebar-link label="Link 2" icon="fa-regular fa-square" color="warning"/>

                <x-ladmin-sidebar-link label="Link 3" icon="fa-regular fa-circle-dot"
                    badge="5" badge-color="info"/>

                <x-ladmin-sidebar-link label="Link 4" icon="fa-solid fa-star" color="info"
                    badge="7" badge-color="danger" badge-classes="rounded-circle"/>

                {{-- Treeview menu tests --}}

                <x-ladmin-sidebar-header label="Treeview Menu Tests" icon="fa-regular fa-bookmark"
                    class="text-uppercase fw-bold" color="success"/>

                <x-ladmin-sidebar-treeview label="Menu 1" icon="fa-solid fa-cubes">
                    <x-ladmin-sidebar-link label="Link A" icon="fa-regular fa-circle"/>
                    <x-ladmin-sidebar-link label="Link B" icon="fa-regular fa-circle"/>

                    <x-ladmin-sidebar-treeview label="SubMenu 1-1" icon="fa-solid fa-cubes"
                        color="info" badge="2" badge-color="warning">
                        <x-ladmin-sidebar-link label="Link C" icon="fa-regular fa-circle"/>
                        <x-ladmin-sidebar-link label="Link D" icon="fa-regular fa-circle"/>
                    </x-ladmin-sidebar-treeview>
                </x-ladmin-sidebar-treeview>

                <x-ladmin-sidebar-treeview label="Menu 2" icon="fa-solid fa-cubes">
                    <x-ladmin-sidebar-link label="Link E" icon="fa-regular fa-circle ms-1"/>
                    <x-ladmin-sidebar-link label="Link F" icon="fa-regular fa-circle ms-1"/>

                    <x-ladmin-sidebar-treeview label="SubMenu 2-1" icon="fa-solid fa-cubes ms-1"
                        color="primary" badge="2" badge-color="primary">
                        <x-ladmin-sidebar-link label="Link G" icon="fa-regular fa-circle ms-2"/>
                        <x-ladmin-sidebar-link label="Link H" icon="fa-regular fa-circle ms-2"/>
                    </x-ladmin-sidebar-treeview>
                    <x-ladmin-sidebar-treeview label="SubMenu 2-2" icon="fa-solid fa-cubes ms-1"
                        color="warning" badge="1" badge-color="warning">
                        <x-ladmin-sidebar-link label="Link I" icon="fa-regular fa-circle ms-2"/>
                    </x-ladmin-sidebar-treeview>
                </x-ladmin-sidebar-treeview>

                <x-ladmin-sidebar-treeview label="Menu 3" icon="fa-solid fa-cubes"
                    color="danger" badge="2" toggler-icon="fa-solid fa-caret-right">
                    <x-ladmin-sidebar-link label="Link J" icon="fa-regular fa-circle"/>
                    <x-ladmin-sidebar-link label="Link K" icon="fa-regular fa-circle"/>
                </x-ladmin-sidebar-treeview>

            </ul>

        </nav>
    </div>

</aside>
