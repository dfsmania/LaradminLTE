{{-- Profile page --}}
<x-ladmin-panel title="{{ __('ladmin::auth.profile.title') }}">

    {{-- Profile image section --}}
    @if(config('ladmin.auth.features.profile_image', false))
        @include('ladmin::profile.profile-image-section')
        <hr class="border-secondary-subtle">
    @endif

    {{-- Profile information section --}}
    @include('ladmin::profile.profile-info-section')

    {{-- Password update section --}}
    @if(config('ladmin.auth.features.update_passwords', false))
        <hr class="border-secondary-subtle">
        @include('ladmin::profile.password-update-section')
    @endif

    {{-- Account deletion section --}}
    @if(config('ladmin.auth.features.account_deletion', false))
        <hr class="border-secondary-subtle">
        @include('ladmin::profile.delete-account-section')
    @endif

</x-ladmin-panel>
