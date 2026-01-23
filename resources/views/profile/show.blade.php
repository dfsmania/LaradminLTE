{{-- Profile page --}}
<x-ladmin-panel title="{{ __('ladmin::auth.profile.title') }}">

    {{-- Profile information section --}}
    @include('ladmin::profile.profile-info-section')

    {{-- Password update section --}}
    @if(config('ladmin.auth.features.update_passwords', false))
        <hr>
        @include('ladmin::profile.password-update-section')
    @endif

</x-ladmin-panel>
