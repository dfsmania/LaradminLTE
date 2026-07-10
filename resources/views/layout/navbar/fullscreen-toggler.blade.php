{{-- Fullscreen toggler link --}}
<li class="nav-item">
    <a href="#" data-lte-toggle="fullscreen" {{ $attributes->merge(['class' => $linkClasses]) }}>

        {{-- Expand icon --}}
        <i data-lte-icon="maximize" class="{{ $iconExpand }}"></i>

        {{-- Collapse icon --}}
        <i data-lte-icon="minimize" class="{{ $iconCollapse }} d-none"></i>

    </a>
</li>
