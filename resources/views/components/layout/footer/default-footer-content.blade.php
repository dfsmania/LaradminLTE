{{-- Version --}}
<div class="float-end d-none d-sm-inline">
    {{ __('ladmin::layout.footer.version', ['version' => $version]) }}
</div>

{{-- Copyright --}}
<span class="fw-bold">
    {{ __('ladmin::layout.footer.copyright', ['minyear' => $startYear, 'maxyear' => now()->year]) }}
</span>

{{-- Company --}}
<a class="fw-bold text-decoration-none" href="{{ $companyUrl }}" target="_blank">
    {{ $company }}
</a>

{{-- All rights reserved --}}
<span class="d-none d-sm-inline">
    {{ __('ladmin::layout.footer.all_rights_reserved') }}
</span>