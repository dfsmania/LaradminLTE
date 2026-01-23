{{-- Profile information section --}}
<x-ladmin-profile-section title="{{ __('ladmin::auth.profile.profile_info.title') }}"
    description="{{ __('ladmin::auth.profile.profile_info.description') }}">

    @if(config('ladmin.auth.features.update_profile_information', false))
        <form method="POST" action="{{ route('user-profile-information.update') }}">
            @method('PUT')
            @csrf

            {{-- Name --}}
            <x-ladmin-input-group for="name" label="{{ __('ladmin::auth.inputs.name') }}" errors-bag="updateProfileInformation">
                <x-ladmin-input name="name" type="text" value="{{ $user->name }}" no-validation-feedback/>

                <x-slot name="prepend">
                    <span class="input-group-text bg-body-tertiary">
                        <i class="bi bi-person-fill fs-5"></i>
                    </span>
                </x-slot>
            </x-ladmin-input-group>

            {{-- Email address --}}
            <x-ladmin-input-group for="email" label="{{ __('ladmin::auth.inputs.email') }}" errors-bag="updateProfileInformation">
                <x-ladmin-input name="email" type="email" value="{{ $user->email }}" no-validation-feedback/>

                <x-slot name="prepend">
                    <span class="input-group-text bg-body-tertiary">
                        <i class="bi bi-envelope-fill fs-5"></i>
                    </span>
                </x-slot>
            </x-ladmin-input-group>

            {{-- Submit button --}}
            <x-ladmin-button type="submit" theme="secondary" icon="bi bi-save fs-5"
                label="{{ __('ladmin::auth.profile.btn_save') }}"
                class="mt-2 float-end d-flex align-items-center bg-gradient"/>
        </form>
    @else
        {{-- Name (read only) --}}
        <x-ladmin-input-group for="name" label="{{ __('ladmin::auth.inputs.name') }}">
            <x-ladmin-input name="name" type="text" value="{{ $user->name }}" disabled/>

            <x-slot name="prepend">
                <span class="input-group-text bg-body-tertiary">
                    <i class="bi bi-person-fill fs-5"></i>
                </span>
            </x-slot>
        </x-ladmin-input-group>

        {{-- Email address (read only) --}}
        <x-ladmin-input-group for="email" label="{{ __('ladmin::auth.inputs.email') }}">
            <x-ladmin-input name="email" type="email" value="{{ $user->email }}" disabled/>

            <x-slot name="prepend">
                <span class="input-group-text bg-body-tertiary">
                    <i class="bi bi-envelope-fill fs-5"></i>
                </span>
            </x-slot>
        </x-ladmin-input-group>
    @endif

</x-ladmin-profile-section>
