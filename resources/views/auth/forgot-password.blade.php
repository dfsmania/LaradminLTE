{{-- Setup accent theme --}}

@php
    $accentTheme = config('ladmin.auth.accent_theme', 'default');
    $backgroundClass = config("ladmin.auth.accent_themes.{$accentTheme}.background", 'bg-body-tertiary');
    $buttonTheme = config("ladmin.auth.accent_themes.{$accentTheme}.button", 'secondary');
    $iconTheme = config("ladmin.auth.accent_themes.{$accentTheme}.icon", 'secondary');
    $linkTheme = config("ladmin.auth.accent_themes.{$accentTheme}.link", 'secondary');
@endphp

{{-- Define the layout of the page --}}

<x-ladmin-auth-base title="{{ __('ladmin::auth.forgot_password.page_title') }}">

    {{-- Forgot password card --}}
    <div class="card shadow">

        {{-- Card header --}}
        <div class="card-header border-bottom-0 {{ $backgroundClass }}">
            <p class="card-title w-100 text-center">
                {{ __('ladmin::auth.forgot_password.box_title') }}
            </p>
        </div>

        {{-- Card body --}}
        <div class="card-body login-card-body">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Help text --}}
                <p>{{ __('ladmin::auth.forgot_password.box_help') }}</p>

                {{-- Email address --}}
                <x-ladmin-input-group for="email" label="{{ __('ladmin::auth.inputs.email') }}" floating-label>
                    <x-ladmin-input name="email" type="email" placeholder="" required/>

                    <x-slot name="append">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-envelope-fill fs-5 text-{{ $iconTheme }}"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

                {{-- Request password reset link button --}}
                <div class="w-100 clearfix">
                    <x-ladmin-button type="submit" theme="{{ $buttonTheme }}" icon="bi bi-envelope-arrow-up-fill fs-5"
                        label="{{ __('ladmin::auth.forgot_password.request_reset_link') }}"
                        class="w-100 d-flex justify-content-center align-items-center bg-gradient"/>
                </div>

                {{-- Additional links --}}
                <div class="mt-3">
                    {{-- Login link --}}
                    <p class="mb-0">
                        <a class="link-{{ $linkTheme }}" href="{{ route('login') }}">
                            {{ __('ladmin::auth.forgot_password.remember_password') }}
                        </a>
                    </p>
                </div>
            </form>
        </div>

    </div>

    {{-- Request status message --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show text-center shadow mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

</x-ladmin-auth-base>
