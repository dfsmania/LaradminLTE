{{-- Navbar link --}}
<li class="nav-item">

    <a href="{{ $url }}" {{ $attributes->merge(['class' => $makeLinkClasses()]) }}>

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
            <span class="{{ $makeBadgeClasses() }}">
                {{ $badge }}
            </span>
        @endif

    </a>

</li>
