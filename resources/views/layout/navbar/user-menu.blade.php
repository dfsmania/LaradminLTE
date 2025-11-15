{{-- Dropdown user menu --}}
<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ $userImageUrl }}" class="user-image rounded-circle shadow" alt="User Image">
        <span class="d-none d-md-inline">{{ $userName }}</span>
    </a>

    {{-- User menu dropdown --}}
    {{-- TODO: Background classes should be read from config --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end bg-body">

        {{-- User menu header --}}
        <li class="user-header">

            {{-- User image --}}
            <img src="{{ $userImageUrl }}" class="rounded-circle shadow" alt="User Image">

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

                <button type="submit" class="btn btn-outline-danger float-end"
                    title="{{ __('ladmin::auth.logout.sign_out') }}">
                    <i class="bi bi-power fs-5"></i>
                </button>
            </form>

        </li>

    </ul>

</li>
