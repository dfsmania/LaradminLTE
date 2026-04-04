{{-- Delete account section --}}
<x-ladmin-profile-section title="{{ __('ladmin::auth.profile.delete_account.title') }}"
    description="{{ __('ladmin::auth.profile.delete_account.description') }}">

    {{-- Action warning --}}
    <p class="text-muted fw-bold">
        {{ __('ladmin::auth.profile.delete_account.details') }}
    </p>

    {{-- Delete account button --}}
    <x-ladmin-button type="button" theme="danger" icon="bi bi-trash fs-5"
        label="{{ __('ladmin::auth.profile.buttons.delete_account') }}"
        class="float-end d-flex align-items-center bg-gradient"
        data-bs-toggle="modal" data-bs-target="#deleteAccountModal"/>

    {{-- Delete account confirmation modal --}}
    <div class="modal" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
    <div class="modal-content">
        <form method="POST" action="{{ route(config('ladmin.main.routes.as', 'ladmin.') . 'user.destroy') }}">
            @csrf
            @method('DELETE')

            {{-- Modal header --}}
            <div class="modal-header text-bg-danger justify-content-center border-bottom-0">
                <h5 class="modal-title fw-bold">
                    {{ __('ladmin::auth.profile.delete_account.title') }}
                </h5>
            </div>

            {{-- Modal body --}}
            <div class="modal-body">
                {{-- Warning message --}}
                <p class="text-muted fw-bold">
                    {{ __('ladmin::auth.profile.delete_account.modal_warning') }}
                </p>

                {{-- Password --}}
                <x-ladmin-input-group for="password" label="{{ __('ladmin::auth.inputs.password') }}" floating-label errors-bag="deleteAccount">
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

                {{-- Delete account submit button --}}
                <x-ladmin-button type="submit" theme="danger" icon="bi bi-trash fs-5"
                    label="{{ __('ladmin::auth.profile.buttons.delete_account') }}"
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
        // Check if there are validation errors in the 'deleteAccount' error
        // bag. If there are, it means the form was submitted but failed
        // validation. In that case, we show the modal again so the user can
        // see the errors.

        const valErrors = @json($errors->deleteAccount->isNotEmpty());

        if (valErrors) {
            const modal = document.getElementById('deleteAccountModal');
            (new bootstrap.Modal(modal)).show();
        }
    });

</script>
@endpush
