{{-- Footer --}}
<footer class="{{ $makeFooterClasses() }}" data-bs-theme="{{ $makeBootstrapTheme() }}">

    @if($slot->isNotEmpty())
        {{-- Custom footer content via slot --}}
        {{ $slot }}
    @else
        {{-- Default footer content --}}
        <x-ladmin-default-footer-content/>
    @endif

</footer>
