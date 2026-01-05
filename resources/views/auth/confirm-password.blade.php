{{-- Setup accent theme --}}

@php
    $accentTheme = config('ladmin.auth.accent_theme', 'default');
    $backgroundClass = config("ladmin.auth.accent_themes.{$accentTheme}.background", 'bg-body-tertiary');
    $buttonTheme = config("ladmin.auth.accent_themes.{$accentTheme}.button", 'secondary');
    $iconTheme = config("ladmin.auth.accent_themes.{$accentTheme}.icon", 'secondary');
    $linkTheme = config("ladmin.auth.accent_themes.{$accentTheme}.link", 'secondary');
@endphp

{{-- Define the layout of the page --}}

<x-ladmin-auth-base title="{{ __('ladmin::auth.confirm_password.page_title') }}">

    {{-- Confirm password card --}}
    <div class="card shadow">

        {{-- Card header --}}
        <div class="card-header border-bottom-0 {{ $backgroundClass }}">
            <p class="card-title w-100 text-center">
                {{ __('ladmin::auth.confirm_password.box_title') }}
            </p>
        </div>

        {{-- Card body --}}
        <div class="card-body login-card-body">
            <form method="POST" action="{{ route('password.confirm.store') }}">
                @csrf

                {{-- Help text --}}
                <p>{{ __('ladmin::auth.confirm_password.box_help') }}</p>

                {{-- Password --}}
                <x-ladmin-input-group for="password" label="{{ __('ladmin::auth.inputs.password') }}" floating-label>
                    <x-ladmin-input name="password" type="password" placeholder="" required/>

                    <x-slot name="append">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-lock-fill fs-5 text-{{ $iconTheme }}"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

                {{-- Confirm password button --}}
                <div class="w-100 clearfix">
                    <x-ladmin-button type="submit" theme="{{ $buttonTheme }}" icon="bi bi-check-circle-fill fs-5"
                        label="{{ __('ladmin::auth.confirm_password.confirm_password') }}"
                        class="w-100 d-flex justify-content-center align-items-center bg-gradient"/>
                </div>

                {{-- Additional links --}}
                <div class="mt-3">
                    {{-- Return back link --}}
                    <p class="mb-0">
                        <a class="link-{{ $linkTheme }}" href="javascript:window.history.back()">
                            {{ __('ladmin::auth.confirm_password.return_back') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>

    </div>

</x-ladmin-auth-base>
