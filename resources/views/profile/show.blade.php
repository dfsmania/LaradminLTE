{{-- Profile page --}}
<x-ladmin-panel title="{{ __('ladmin::auth.profile.title') }}">

    {{-- Profile image section --}}
    @if(config('ladmin.auth.features.profile_image', false))
        @include('ladmin::profile.profile-image-section')
        <hr>
    @endif

    {{-- Profile information section --}}
    @include('ladmin::profile.profile-info-section')

    {{-- Password update section --}}
    @if(config('ladmin.auth.features.update_passwords', false))
        <hr>
        @include('ladmin::profile.password-update-section')
    @endif

</x-ladmin-panel>
