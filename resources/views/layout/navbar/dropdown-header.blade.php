{{-- Navbar dropdown header --}}
<li>
    <h6 {{ $attributes->merge(['class' => $headerClasses]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="{{ $icon }} me-1"></i>
        @endif

        {{-- Label --}}
        <span>{{ $label }}</span>

    </h6>
</li>
