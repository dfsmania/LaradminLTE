{{-- Navbar dropdown menu --}}
<li class="nav-item dropdown">

    {{-- Dropdown toggler link --}}
    <a href="#" data-bs-toggle="dropdown" role="button" {{ $attributes->merge(['class' => $linkClasses]) }}>

        {{-- Icon (optional) --}}
        @if(! empty($icon))
            <i class="{{ empty($label) ? $icon : "$icon me-1" }}"></i>
        @endif

        {{-- Label (optional) --}}
        @if(! empty($label))
            <span>{{ $label }}</span>
        @endif

    </a>

    {{-- Dropdown children items --}}
    @if(! empty($slot))
        <ul class="{{ $menuClasses }}">
            {{ $slot }}
        </ul>
    @endif

</li>
