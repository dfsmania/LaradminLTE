{{-- Treeview menu --}}

<li class="nav-item">

    {{-- Treeview link --}}
    <a href="javascript:;" {{ $attributes->merge(['class' => $makeLinkClasses()]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="nav-icon {{ $icon }}"></i>
        @endif

        {{-- Label --}}
        <p>
            {{ $label }}
            <i class="nav-arrow fa-solid fa-angle-right"></i>
        </p>

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
