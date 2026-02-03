{{-- Dropdown user menu --}}
<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

        @if($userImageUrl)
            <img src="{{ $userImageUrl }}" class="user-image rounded-circle shadow"
                alt="{{ __('ladmin::auth.profile.profile_image.title') }}">
            <span class="d-none d-md-inline">{{ $userName }}</span>
        @else
            <span class="d-inline">{{ $userName }}</span>
        @endif
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">

        {{-- User menu header --}}
        <li class="user-header">

            {{-- User image --}}
            @if($userImageUrl)
                <img src="{{ $userImageUrl }}" class="rounded-circle shadow border border-2 border-secondary-subtle"
                    alt="{{ __('ladmin::auth.profile.profile_image.title') }}">
            @endif

            {{-- User name --}}
            <p class="fw-bold">{{ $userName }}</p>

            {{-- User email --}}
            <small>{{ $userEmail }}</small>

        </li>

        {{-- User menu body --}}
        <li class="user-footer">

            {{-- Sign out form --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-ladmin-button type="submit" theme="outline-danger" icon="bi bi-power fs-5" class="float-end"
                    title="{{ __('ladmin::auth.logout.sign_out') }}"/>
            </form>

            {{-- Profile link --}}
            <x-ladmin-button theme="outline-secondary" icon="bi bi-person-fill-gear fs-5" title="{{ __('ladmin::auth.profile.title') }}"
                onclick="window.location='{{ route(config('ladmin.main.routes.as', 'ladmin.') . 'profile.show') }}'"/>

        </li>

    </ul>

</li>
