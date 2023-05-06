{{-- Sidebar --}}
{{-- TODO: What properties may be add to the component? --}}

<aside class="{{ $makeSidebarClasses() }}" data-bs-theme="dark">

    {{-- Sidebar brand --}}
    <x-ladmin-sidebar-brand label="AdminLTE"
        logo="{{ asset('vendor/laralive-admin/img/AdminLTELogo.png') }}"
        logo-alt="AdminLTE"
        label-classes="text-info fw-bold opacity-75"
        logo-classes="opacity-75 shadow"/>

    {{-- Sidebar menu wrapper --}}
    {{-- TODO: Create components for sidebar items (example, link and treeview) --}}
    <div class="sidebar-wrapper">
        <nav class="mt-2">

            {{-- Sidebar menu --}}
            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                data-accordion="false"
                role="menu">

                <x-ladmin-sidebar-link label="Link 1" icon="fa-regular fa-circle"/>

                <x-ladmin-sidebar-link label="Link 2" icon="fa-regular fa-square" theme="warning"/>

                <x-ladmin-sidebar-link label="Link 3" icon="fa-solid fa-tag"
                    badge="5" badge-theme="info"/>

                <x-ladmin-sidebar-link label="Link 4" icon="fa-solid fa-user" theme="info"
                    badge="7" badge-theme="danger" badge-classes="rounded-circle"/>

            </ul>

        </nav>
    </div>

</aside>
