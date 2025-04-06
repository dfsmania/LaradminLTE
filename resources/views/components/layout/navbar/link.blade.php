{{-- Navbar link --}}
<li class="nav-item">

    <a href="{{ $url }}" {{ $attributes->merge(['class' => $linkClasses]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="{{ $icon }}"></i>
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
