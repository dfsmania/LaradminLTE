{{-- Main content --}}
<main class="{{ $mainContentClasses }}">

    {{-- Content header --}}
    @isset($contentHeader)
        <div class="app-content-header">
            <div class="container-fluid">
                {{ $contentHeader }}
            </div>
        </div>
    @endisset

    {{-- Content body --}}
    <div class="app-content">
        <div class="container-fluid">
            {{ $slot }}
        </div>
    </div>

</main>
