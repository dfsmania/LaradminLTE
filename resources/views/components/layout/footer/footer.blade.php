{{-- Footer --}}
<footer class="{{ $footerClasses }}">

    @if($slot->isNotEmpty())
        {{-- Custom footer content via slot --}}
        {{ $slot }}
    @else
        {{-- Default footer content --}}
        <x-ladmin-default-footer-content/>
    @endif

</footer>
