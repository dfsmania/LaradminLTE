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

                {{-- Sidebar menu items --}}
                @foreach(ladmin()->menu->getSidebarMenuItems() as $item)
                    {!! $item->render() !!}
                @endforeach

            </ul>

        </nav>
    </div>

</aside>
