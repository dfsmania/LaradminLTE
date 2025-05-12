{{-- Navbar dropdown header --}}
<li {{ $attributes->merge(['class' => $headerClasses]) }}>

    {{-- Icon (optional) --}}
    @if(! empty($icon))
        <i class="{{ $icon }} me-1"></i>
    @endif

    {{-- Label --}}
    <span>{{ $label }}</span>

</li>
