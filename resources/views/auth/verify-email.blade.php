{{-- Setup accent theme --}}

@php
    $accentTheme = config('ladmin.auth.accent_theme', 'default');
    $backgroundClass = config("ladmin.auth.accent_themes.{$accentTheme}.background", 'bg-body-tertiary');
    $buttonTheme = config("ladmin.auth.accent_themes.{$accentTheme}.button", 'secondary');
    $iconTheme = config("ladmin.auth.accent_themes.{$accentTheme}.icon", 'secondary');
    $linkTheme = config("ladmin.auth.accent_themes.{$accentTheme}.link", 'secondary');
@endphp

{{-- Define the layout of the page --}}

<x-ladmin-auth-base title="{{ __('ladmin::auth.verify_email.page_title') }}">

    {{-- Verify email card --}}
    <div class="card shadow">

        {{-- Card header --}}
        <div class="card-header border-bottom-0 {{ $backgroundClass }}">
            <p class="card-title w-100 text-center">
                {{ __('ladmin::auth.verify_email.box_title') }}
            </p>
        </div>

        {{-- Card body --}}
        <div class="card-body login-card-body rounded-bottom">

            {{-- Verification email resend form --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                {{-- Help text --}}
                <p>{{ __('ladmin::auth.verify_email.box_help') }}</p>

                {{-- Actions and links --}}
                <div class="d-flex flex-column">

                    {{-- Resend verification email link button --}}
                    <x-ladmin-button type="submit" theme="{{ $buttonTheme }}" icon="bi bi-envelope-arrow-up-fill fs-5"
                        label="{{ __('ladmin::auth.verify_email.resend_email') }}"
                        class="d-flex justify-content-center align-items-center bg-gradient"/>

                </div>
            </form>

            {{-- Logout form --}}
            <form class="mt-3" method="POST" action="{{ route('logout') }}">
                @csrf

                {{-- Sign out link --}}
                <a class="link-{{ $linkTheme }}" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('ladmin::auth.verify_email.sign_out') }}
                </a>
            </form>

        </div>

    </div>

    {{-- Verify link sent status message --}}
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success alert-dismissible fade show text-center shadow mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ __('ladmin::auth.verify_email.resend_ok_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

</x-ladmin-auth-base>
