{{-- Sidebar --}}
{{-- TODO: Make the basic sidebar markup --}}
{{-- TODO: What properties may be add to the component? --}}

<aside class="{{ $makeSidebarClasses() }}" data-bs-theme="dark">

    {{-- Sidebar brand --}}
    <x-ladmin-sidebar-brand label="AdminLTE"
        logo="{{ asset('vendor/laralive-admin/img/AdminLTELogo.png') }}"
        logo-alt="AdminLTE"
        logo-classes="opacity-75 shadow rounded-circle"/>

    {{-- Sidebar menu wrapper --}}
    {{-- TODO: Create components for sidebar items (example, link and treeview) --}}
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            SIDEBAR
        </nav>
    </div>

</aside>
