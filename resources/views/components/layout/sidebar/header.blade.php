{{-- Sidebar header --}}

<li {{ $attributes->merge(['class' => $makeHeaderClasses()]) }}>

    {{-- Icon (optional) --}}
    @if(! empty($icon))
        <i class="{{ $icon }}"></i>
    @endif

    {{-- Label --}}
    <span class="{{ $makeLabelClasses() }}">
        {{ $label }}
    </span>

</li>
