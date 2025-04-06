{{-- Sidebar brand link --}}
<div class="sidebar-brand">

    <a href="{{ $url }}" {{ $attributes->merge(['class' => 'brand-link user-select-none']) }}>

        {{-- Logo (optional) --}}
        @if (! empty($logoUrl))
            <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}" class="{{ $logoClasses }}">
        @endif

        {{-- Label (optional) --}}
        @if (! empty($label))
            <span class="{{ $labelClasses }}">{{ $label }}</span>
        @endif

    </a>

</div>
