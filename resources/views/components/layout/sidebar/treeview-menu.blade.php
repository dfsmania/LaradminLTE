{{-- Treeview menu --}}
<li class="nav-item">

    {{-- Treeview link --}}
    <a href="#" {{ $attributes->merge(['class' => $linkClasses]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="nav-icon {{ $icon }}"></i>
        @endif

        {{-- Label --}}
        <p>{{ $label }}</p>

        {{-- Toggler icon --}}
        @if(! empty($togglerIcon))
            <i class="nav-arrow {{ $togglerIcon }}"></i>
        @else
            <span class="nav-arrow h3">&rsaquo;</span>
        @endif

        {{-- Badge (optional) --}}
        @if(! empty($badge))
            <span class="{{ $badgeClasses }}">
                {{ $badge }}
            </span>
        @endif

    </a>

    {{-- Treeview menu items --}}
    @if(! empty($slot))
        <ul class="nav nav-treeview">
            {{ $slot }}
        </ul>
    @endif

</li>
