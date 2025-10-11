{{-- Authentication logo --}}
<div class="login-logo">

    {{-- Logo image (optional) --}}
    @if (! empty($logoUrl))
        <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}" class="{{ $logoClasses }}"
            height="{{ $logoHeight }}" width="{{ $logoWidth }}">
    @endif

    {{-- Logo label (optional) --}}
    @if (! empty($label))
        <span class="{{ $labelClasses }}">{{ $label }}</span>
    @endif

</div>
