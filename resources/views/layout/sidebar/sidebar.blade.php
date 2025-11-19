{{-- Sidebar --}}
<aside class="{{ $sidebarClasses }}" data-bs-theme="{{ $bootstrapTheme }}">

    {{-- Sidebar brand --}}
    <x-ladmin-sidebar-brand label="{{ config('ladmin.main.logo.text', 'AdminLTE') }}"
        logo-url="{{ config('ladmin.main.logo.image', '') }}"
        logo-alt="{{ config('ladmin.main.logo.image_alt', 'AdminLTE Logo') }}"
        label-classes="{{ $brandTextClasses }}"
        logo-classes="{{ $brandImageClasses }}"/>

    {{-- Sidebar menu wrapper --}}
    <div class="sidebar-wrapper">
        <nav class="mt-2">

            {{-- Sidebar menu --}}
            <ul class="nav sidebar-menu flex-column"
                data-accordion="{{ config('ladmin.main.sidebar.accordion', false) ? 'true' : 'false' }}"
                data-animation-speed="{{ config('ladmin.main.sidebar.treeview_animation_speed', 300) }}"
                data-lte-toggle="treeview"
                role="menu">

                {{-- Sidebar menu items --}}
                @foreach(ladmin()->menu->getSidebarItems() as $item)
                    {{ $item->renderToHtml() }}
                @endforeach

            </ul>

        </nav>
    </div>

</aside>
