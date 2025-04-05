{{-- Footer --}}
<footer class="{{ $footerClasses }}" data-bs-theme="{{ $bootstrapTheme }}">

    @if($slot->isNotEmpty())
        {{-- Custom footer content via slot --}}
        {{ $slot }}
    @else
        {{-- Default footer content --}}
        <x-ladmin-default-footer-content/>
    @endif

</footer>
