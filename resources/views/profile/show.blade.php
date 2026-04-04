{{-- Profile page --}}
<x-ladmin-panel title="{{ __('ladmin::auth.profile.title') }}">
<div id="profileContent">

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

    {{-- Browser sessions section --}}
    @if(config('ladmin.auth.features.browser_sessions', false))
        <hr class="border-secondary-subtle">
        @include('ladmin::profile.browser-sessions-section')
    @endif

    {{-- Account deletion section --}}
    @if(config('ladmin.auth.features.account_deletion', false))
        <hr class="border-secondary-subtle">
        @include('ladmin::profile.delete-account-section')
    @endif

    {{-- Extra JS --}}
    @push('js')
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Listen for each form submission event and save the current
            // scroll position in sessionStorage, so we can restore it after
            // the form submission.

            const profileContent = document.getElementById('profileContent');

            profileContent.querySelectorAll('form').forEach(function (f) {
                f.addEventListener('submit', function () {
                    sessionStorage.setItem(
                        'ladmin.scroll.position',
                        window.scrollY || document.documentElement.scrollTop
                    );
                });
            });

            // After the page loads, check if there is a saved scroll position
            // in sessionStorage. If there is, scroll to that position and then
            // remove it from sessionStorage.

            const scrollPos = parseInt(
                sessionStorage.getItem('ladmin.scroll.position')
            );

            if (! isNaN(scrollPos)) {
                requestAnimationFrame(() => {
                    window.scrollTo({ top: scrollPos, behavior: 'instant' });
                    sessionStorage.removeItem('ladmin.scroll.position');
                });
            }
        });

    </script>
    @endpush

</div>
</x-ladmin-panel>
