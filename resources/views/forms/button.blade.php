{{-- Button element --}}
<button {{ $attributes->merge(['class' => $buttonClasses]) }}>

    {{-- Icon --}}
    @if(! empty($icon))
        <i class="{{ $icon }}"></i>
    @endif

    {{-- Label --}}
    @if(! empty($label))
        {{ $label }}
    @endif

    {{-- Slot content, to support custom markup --}}
    {{ $slot }}

</button>
