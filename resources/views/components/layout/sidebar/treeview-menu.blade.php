{{-- Treeview menu --}}
<li class="nav-item">

    {{-- Treeview link --}}
    <a href="#" {{ $attributes->merge(['class' => $makeLinkClasses()]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="nav-icon {{ $icon }}"></i>
        @endif

        {{-- Label --}}
        <p>{{ $label }}</p>

        {{-- Toggler icon --}}
        <i class="nav-arrow {{ $togglerIcon }}"></i>

        {{-- Badge (optional) --}}
        @if(! empty($badge))
            <span class="{{ $makeBadgeClasses() }}">
                {{ $badge }}
            </span>
        @endif

    </a>

    {{-- Treeview menu items --}}
    <ul class="nav nav-treeview">
        {{ $slot }}
    </ul>

</li>
