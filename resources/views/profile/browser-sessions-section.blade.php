{{-- Browser sessions section --}}
<x-ladmin-profile-section title="{{ __('ladmin::auth.profile.browser_sessions.title') }}"
    description="{{ __('ladmin::auth.profile.browser_sessions.description') }}">

    {{-- Action warning --}}
    <p class="text-muted fw-bold">
        {{ __('ladmin::auth.profile.browser_sessions.details') }}
    </p>

    {{-- User sessions --}}
    @foreach($sessions as $session)
        <div class="d-flex align-items-center mb-3">

            {{-- Device icon --}}
            <div class="mt-1 me-3 text-secondary">
                @if($session->agent->isDesktop())
                    <i class="bi bi-pc-display-horizontal fs-3"></i>
                @else
                    <i class="bi bi-phone fs-3"></i>
                @endif
            </div>

            <div>
                {{-- Platform and browser --}}
                <div class="text-secondary fw-bold">
                    {{ $session->agent->platform() ?? __('ladmin::auth.profile.labels.unknown') }} -
                    {{ $session->agent->browser() ?? __('ladmin::auth.profile.labels.unknown') }}
                </div>

                {{-- IP address and last active time --}}
                <div>
                    <span class="text-muted small me-1">
                        IP: {{ $session->ip_address }}
                    </span>

                    @if($session->is_current_device)
                        <span class="badge rounded-pill text-bg-success fw-bold">
                            {{ __('ladmin::auth.profile.labels.this_dev') }}
                        </span>
                    @else
                        <span class="badge rounded-pill text-bg-secondary">
                            {{ __('ladmin::auth.profile.labels.last_active') }}: {{ $session->last_active }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    {{-- Logout other browser sessions button --}}
    <x-ladmin-button type="button" theme="secondary" icon="bi bi-box-arrow-right fs-5"
        label="{{ __('ladmin::auth.profile.buttons.logout_other_sessions') }}"
        class="float-end d-flex align-items-center bg-gradient"
        data-bs-toggle="modal" data-bs-target="#logoutOtherSessionsModal"/>

    {{-- Logout other browser sessions confirmation modal --}}
    <div class="modal" id="logoutOtherSessionsModal" tabindex="-1">
    <div class="modal-dialog">
    <div class="modal-content">
        <form method="POST" action="{{ route(config('ladmin.main.routes.as', 'ladmin.') . 'user-sessions.destroy') }}">
            @csrf
            @method('DELETE')

            {{-- Modal header --}}
            <div class="modal-header text-bg-dark justify-content-center border-bottom-0">
                <h5 class="modal-title fw-bold">
                    {{ __('ladmin::auth.profile.browser_sessions.modal_title') }}
                </h5>
            </div>

            {{-- Modal body --}}
            <div class="modal-body">
                {{-- Warning message --}}
                <p class="text-muted fw-bold">
                    {{ __('ladmin::auth.profile.browser_sessions.modal_warning') }}
                </p>

                {{-- Password --}}
                <x-ladmin-input-group for="password" label="{{ __('ladmin::auth.inputs.password') }}" floating-label errors-bag="logoutOtherSessions">
                    <x-ladmin-input name="password" type="password" placeholder="" no-validation-feedback required/>

                    <x-slot name="append">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-lock-fill fs-5"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>
            </div>

            {{-- Modal footer --}}
            <div class="modal-footer bg-light border-top-0 justify-content-between">
                {{-- Cancel button --}}
                <x-ladmin-button type="button" theme="secondary" icon="bi bi-x-circle fs-5"
                    label="{{ __('ladmin::auth.profile.buttons.cancel') }}"
                    class="d-flex align-items-center bg-gradient" data-bs-dismiss="modal"/>

                {{-- Logout other sessions submit button --}}
                <x-ladmin-button type="submit" theme="dark" icon="bi bi-box-arrow-right fs-5"
                    label="{{ __('ladmin::auth.profile.buttons.logout_other_sessions') }}"
                    class="float-end d-flex align-items-center bg-gradient"/>
            </div>
        </form>
    </div>
    </div>
    </div>

</x-ladmin-profile-section>

{{-- Extra JS --}}
@push('js')
<script>

    document.addEventListener('DOMContentLoaded', function () {
        // Check if there are validation errors in the 'logoutOtherSessions'
        // error bag. If there are, it means the form was submitted but failed
        // validation. In that case, we show the modal again so the user can
        // see the errors.

        const valErrors = @json($errors->logoutOtherSessions->isNotEmpty());

        if (valErrors) {
            const modal = document.getElementById('logoutOtherSessionsModal');
            (new bootstrap.Modal(modal)).show();
        }
    });

</script>
@endpush
