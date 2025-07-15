{{-- Navbar dropdown link --}}
<li>

    <a href="{{ $url }}" {{ $attributes->merge(['class' => $linkClasses]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="{{ empty($label) ? $icon : "$icon me-1" }}"></i>
        @endif

        {{-- Label (optional) --}}
        @if(! empty($label))
            <span>{{ $label }}</span>
        @endif

        {{-- Badge (optional) --}}
        @if(! empty($badge))
            <span class="{{ $badgeClasses }}">
                {{ $badge }}
            </span>
        @endif

    </a>

</li>
