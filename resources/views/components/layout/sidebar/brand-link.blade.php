{{-- Sidebar Brand Link --}}

<div class="sidebar-brand">

    <a href="{{ $url }}" {{ $attributes->merge(['class' => 'brand-link']) }}>

        {{-- Logo (optional) --}}
        @if (! empty($logo))
            <img src="{{ $logo }}" alt="{{ $logoAlt }}" class="{{ $makeLogoClasses() }}">
        @endif

        {{-- Label (optional) --}}
        {{-- TODO: Check for more label customizations (classes) --}}
        @if (! empty($label))
            <span class="brand-text">{{ $label }}</span>
        @endif

    </a>

</div>
