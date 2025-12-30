{{-- Setup accent theme --}}

@php
    $accentTheme = config('ladmin.auth.accent_theme', 'default');
    $backgroundClass = config("ladmin.auth.accent_themes.{$accentTheme}.background", 'bg-body-tertiary');
    $buttonTheme = config("ladmin.auth.accent_themes.{$accentTheme}.button", 'secondary');
    $iconTheme = config("ladmin.auth.accent_themes.{$accentTheme}.icon", 'secondary');
    $linkTheme = config("ladmin.auth.accent_themes.{$accentTheme}.link", 'secondary');
@endphp

{{-- Define the layout of the page --}}

<x-ladmin-auth-base title="{{ __('ladmin::auth.register.page_title') }}">

    {{-- Register card --}}
    <div class="card shadow">

        {{-- Card header --}}
        <div class="card-header border-bottom-0 {{ $backgroundClass }}">
            <p class="card-title w-100 text-center">
                {{ __('ladmin::auth.register.box_title') }}
            </p>
        </div>

        {{-- Card body --}}
        <div class="card-body login-card-body">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <x-ladmin-input-group for="name" label="{{ __('ladmin::auth.inputs.name') }}" floating-label>
                    <x-ladmin-input name="name" type="text" placeholder="" required/>

                    <x-slot name="append">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-person-fill fs-5 text-{{ $iconTheme }}"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

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

                {{-- Register button --}}
                <div class="w-100 clearfix">
                    <x-ladmin-button type="submit" theme="{{ $buttonTheme }}" icon="bi bi-person-plus-fill fs-5"
                        label="{{ __('ladmin::auth.register.register') }}" class="float-end d-flex align-items-center bg-gradient"/>
                </div>

                {{-- Additional links --}}
                <div>
                    {{-- Login link --}}
                    <p class="mb-0">
                        <a class="link-{{ $linkTheme }}" href="{{ route('login') }}">
                            {{ __('ladmin::auth.register.already_have_account') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>

    </div>

</x-ladmin-auth-base>
