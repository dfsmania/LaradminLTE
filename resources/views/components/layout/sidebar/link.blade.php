{{-- Menu link --}}

<li class="nav-item">

    <a href="{{ $url }}" {{ $attributes->merge(['class' => $makeLinkClasses()]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="nav-icon {{ $icon }}"></i>
        @endif

        {{-- Label (optional) --}}
        @if(! empty($label))
            <p>{{ $label }}</p>
        @endif

        {{-- Badge (optional) --}}
        @if(! empty($badge))
            <span class="{{ $makeBadgeClasses() }}">
                {{ $badge }}
            </span>
        @endif

    </a>

</li>
