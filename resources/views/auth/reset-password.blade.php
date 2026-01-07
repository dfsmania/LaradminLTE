{{-- Setup accent theme --}}

@php
    $accentTheme = config('ladmin.auth.accent_theme', 'default');
    $backgroundClass = config("ladmin.auth.accent_themes.{$accentTheme}.background", 'bg-body-tertiary');
    $buttonTheme = config("ladmin.auth.accent_themes.{$accentTheme}.button", 'secondary');
    $iconTheme = config("ladmin.auth.accent_themes.{$accentTheme}.icon", 'secondary');
    $linkTheme = config("ladmin.auth.accent_themes.{$accentTheme}.link", 'secondary');
@endphp

{{-- Define the layout of the page --}}

<x-ladmin-auth-base title="{{ __('ladmin::auth.reset_password.page_title') }}">

    {{-- Reset password card --}}
    <div class="card shadow">

        {{-- Card header --}}
        <div class="card-header border-bottom-0 {{ $backgroundClass }}">
            <p class="card-title w-100 text-center">
                {{ __('ladmin::auth.reset_password.box_title') }}
            </p>
        </div>

        {{-- Card body --}}
        <div class="card-body login-card-body rounded-bottom">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                {{-- Password reset token --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email address --}}
                <x-ladmin-input-group for="email" label="{{ __('ladmin::auth.inputs.email') }}" floating-label>
                    <x-ladmin-input name="email" type="email" placeholder="" required/>

                    <x-slot name="append">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-envelope-fill fs-5 text-{{ $iconTheme }}"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

                {{-- Password --}}
                <x-ladmin-input-group for="password" label="{{ __('ladmin::auth.inputs.password') }}" floating-label>
                    <x-ladmin-input name="password" type="password" placeholder="" required/>

                    <x-slot name="append">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-lock-fill fs-5 text-{{ $iconTheme }}"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

                {{-- Confirm Password --}}
                <x-ladmin-input-group for="password_confirmation" label="{{ __('ladmin::auth.inputs.confirm_password') }}" floating-label
                    no-validation-feedback>
                    <x-ladmin-input name="password_confirmation" type="password" placeholder="" required no-validation-feedback/>

                    <x-slot name="append">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-lock-fill fs-5 text-{{ $iconTheme }}"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

                {{-- Actions and links --}}
                <div class="d-flex flex-column">

                    {{-- Reset password button --}}
                    <x-ladmin-button type="submit" theme="{{ $buttonTheme }}" icon="bi bi-person-fill-lock fs-5"
                        label="{{ __('ladmin::auth.reset_password.reset_password') }}"
                        class="d-flex justify-content-center align-items-center bg-gradient"/>

                </div>
            </form>
        </div>

    </div>

</x-ladmin-auth-base>
