{{-- Sidebar link --}}
<li class="nav-item">

    <a href="{{ $url }}" {{ $attributes->merge(['class' => $linkClasses]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="nav-icon {{ $icon }}"></i>
        @endif

        {{-- Label --}}
        <p>{{ $label }}</p>

        {{-- Badge (optional) --}}
        @if(! empty($badge))
            <span class="{{ $badgeClasses }}">
                {{ $badge }}
            </span>
        @endif

    </a>

</li>
