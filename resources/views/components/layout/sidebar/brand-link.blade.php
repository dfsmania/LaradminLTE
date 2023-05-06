{{-- Sidebar brand link --}}

<div class="sidebar-brand">

    <a href="{{ $url }}" {{ $attributes->merge(['class' => 'brand-link']) }}>

        {{-- Logo (optional) --}}
        @if (! empty($logo))
            <img src="{{ $logo }}" alt="{{ $logoAlt }}" class="{{ $makeLogoClasses() }}">
        @endif

        {{-- Label (optional) --}}
        @if (! empty($label))
            <span class="{{ $makeLabelClasses() }}">{{ $label }}</span>
        @endif

    </a>

</div>
