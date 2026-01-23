{{-- Password update section --}}
<x-ladmin-profile-section title="{{ __('ladmin::auth.profile.update_password.title') }}"
    description="{{ __('ladmin::auth.profile.update_password.description') }}">

    <form method="POST" action="{{ route('user-password.update') }}">
        @method('PUT')
        @csrf

        {{-- Current password --}}
        <x-ladmin-input-group for="current_password" label="{{ __('ladmin::auth.inputs.current_password') }}" errors-bag="updatePassword">
            <x-ladmin-input name="current_password" type="password" no-validation-feedback required/>

            <x-slot name="prepend">
                <span class="input-group-text bg-body-tertiary">
                    <i class="bi bi-lock fs-5"></i>
                </span>
            </x-slot>
        </x-ladmin-input-group>

        {{-- New password --}}
        <x-ladmin-input-group for="password" label="{{ __('ladmin::auth.inputs.new_password') }}" errors-bag="updatePassword">
            <x-ladmin-input name="password" type="password" no-validation-feedback required/>

            <x-slot name="prepend">
                <span class="input-group-text bg-body-tertiary">
                    <i class="bi bi-lock-fill fs-5"></i>
                </span>
            </x-slot>
        </x-ladmin-input-group>

        {{-- Confirm new password --}}
        <x-ladmin-input-group for="password_confirmation" label="{{ __('ladmin::auth.inputs.confirm_password') }}" errors-bag="updatePassword">
            <x-ladmin-input name="password_confirmation" type="password" no-validation-feedback required/>

            <x-slot name="prepend">
                <span class="input-group-text bg-body-tertiary">
                    <i class="bi bi-lock-fill fs-5"></i>
                </span>
            </x-slot>
        </x-ladmin-input-group>

        {{-- Submit button --}}
        <x-ladmin-button type="submit" theme="secondary" icon="bi bi-save fs-5"
            label="{{ __('ladmin::auth.profile.btn_save') }}"
            class="mt-2 float-end d-flex align-items-center bg-gradient"/>
    </form>

</x-ladmin-profile-section>
