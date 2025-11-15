<x-ladmin-auth-base title="{{ __('ladmin::auth.login.page_title') }}">

    {{-- Login card --}}
    <div class="card">

        {{-- Card header --}}
        <div class="card-header border-bottom-0 bg-body-tertiary">
            <p class="card-title w-100 text-center">
                {{ __('ladmin::auth.login.box_title') }}
            </p>
        </div>

        {{-- Card body --}}
        <div class="card-body login-card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email address --}}
                <x-ladmin-input-group for="email" label="{{ __('ladmin::auth.login.email') }}" floating-label>
                    <x-ladmin-input name="email" type="email" placeholder="" required/>

                    <x-slot name="prepend">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-envelope fs-5"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

                {{-- Password --}}
                <x-ladmin-input-group for="password" label="{{ __('ladmin::auth.login.password') }}" floating-label no-validation-feedback>
                    <x-ladmin-input name="password" type="password" placeholder="" no-validation-feedback required/>

                    <x-slot name="prepend">
                        <span class="input-group-text bg-body-tertiary">
                            <i class="bi bi-lock fs-5"></i>
                        </span>
                    </x-slot>
                </x-ladmin-input-group>

                {{-- Remember me --}}
                <x-ladmin-checkbox name="remember_me" label="{{ __('ladmin::auth.login.remember_me') }}"
                    class="shadow-none" no-validation-feedback/>

                {{-- Sign in button --}}
                <x-ladmin-button type="submit" theme="secondary" label="{{ __('ladmin::auth.login.sign_in') }}"
                    icon="bi bi-box-arrow-in-right fs-5 me-1"
                    class="float-end d-flex align-items-center"/>
            </form>
        </div>

    </div>

</x-ladmin-auth-base>
