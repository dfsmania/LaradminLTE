{{-- Footer --}}
<footer class="app-footer">

    @if($slot->isNotEmpty())
        {{-- Custom footer via slot --}}
        {{ $slot }}
    @else
        {{-- Default footer --}}
        <div class="float-end d-none d-sm-inline">
            {{ __('ladmin::layout.footer.version', ['version' => config('ladmin.basic.version')]) }}
        </div>

        <span class="fw-bold">
            {{ __('ladmin::layout.footer.copyright', ['minyear' => config('ladmin.basic.start_year'), 'maxyear' => now()->year]) }}
        </span>

        <a class="fw-bold text-decoration-none" href="{{ config('ladmin.basic.company_url') }}" target="_blank">
            {{ config('ladmin.basic.company') }}
        </a>

        <span class="d-none d-sm-inline">
            {{ __('ladmin::layout.footer.all_rights_reserved') }}
        </span>
    @endif

</footer>
