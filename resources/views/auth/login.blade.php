{{-- Setup accent theme --}}

@php
    $accentTheme = config('ladmin.auth.accent_theme', 'default');
    $backgroundClass = config("ladmin.auth.accent_themes.{$accentTheme}.background", 'bg-body-tertiary');
    $buttonTheme = config("ladmin.auth.accent_themes.{$accentTheme}.button", 'secondary');
    $iconTheme = config("ladmin.auth.accent_themes.{$accentTheme}.icon", 'secondary');
    $linkTheme = config("ladmin.auth.accent_themes.{$accentTheme}.link", 'secondary');
@endphp

{{-- Define the layout of the page --}}

<x-ladmin-auth-base title="{{ __('ladmin::auth.login.page_title') }}">

    {{-- Login card --}}
    <div class="card shadow">

        {{-- Card header --}}
        <div class="card-header border-bottom-0 {{ $backgroundClass }}">
            <p class="card-title w-100 text-center">
                {{ __('ladmin::auth.login.box_title') }}
            </p>
        </div>

        {{-- Card body --}}
        <div class="card-body login-card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                <x-ladmin-input-group for="password" label="{{ __('ladmin::auth.inputs.password') }}" floating-label no-validation-feedback>
                    <x-ladmin-input name="password" type="password" placeholder="" required no-validation-feedback/>

                    <x-slot name="append">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-lock-fill fs-5 text-{{ $iconTheme }}"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

                {{-- Remember me --}}
                <x-ladmin-checkbox name="remember_me" theme="{{ $buttonTheme }}" label="{{ __('ladmin::auth.inputs.remember_me') }}"
                    class="shadow-none" sizing="lg" no-validation-feedback/>

                {{-- Sign in button --}}
                <div class="w-100 clearfix">
                    <x-ladmin-button type="submit" theme="{{ $buttonTheme }}" label="{{ __('ladmin::auth.login.sign_in') }}"
                        icon="bi bi-box-arrow-in-right fs-5 me-1" class="float-end d-flex align-items-center bg-gradient"/>
                </div>

                {{-- Additional links --}}
                <div class="mt-1">

                    {{-- Register link --}}
                    @if(config('ladmin.auth.features.registration', false))
                        <a class="link-{{ $linkTheme }}" href="{{ route('register') }}">
                            {{ __('ladmin::auth.login.register_account') }}
                        </a>
                    @endif

                </div>
            </form>
        </div>

    </div>

</x-ladmin-auth-base>
