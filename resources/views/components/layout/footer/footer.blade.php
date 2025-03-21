{{-- Footer --}}
<footer class="app-footer">

    @if($slot->isNotEmpty())
        {{-- Custom footer via slot --}}
        {{ $slot }}
    @else
        {{-- Default footer --}}
        @php
            $version = config('ladmin.basic.version', '1.0.0');
            $company = config('ladmin.basic.company', 'Company Name');
            $companyUrl = config('ladmin.basic.company_url', '#');
            $startYear = config('ladmin.basic.start_year', '2024');
        @endphp

        <div class="float-end d-none d-sm-inline">
            {{ __('ladmin::layout.footer.version', ['version' => $version]) }}
        </div>

        <span class="fw-bold">
            {{ __('ladmin::layout.footer.copyright', ['minyear' => $startYear, 'maxyear' => now()->year]) }}
        </span>

        <a class="fw-bold text-decoration-none" href="{{ $companyUrl }}" target="_blank">
            {{ $company }}
        </a>

        <span class="d-none d-sm-inline">
            {{ __('ladmin::layout.footer.all_rights_reserved') }}
        </span>
    @endif

</footer>
