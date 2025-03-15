{{-- Main content --}}
<main class="app-main">

    {{-- Content Header --}}
    @isset($contentHeader)
        <div class="app-content-header">
            <div class="container-fluid">
                {{ $contentHeader }}
            </div>
        </div>
    @endisset

    {{-- Content Body --}}
    <div class="app-content">
        <div class="container-fluid">
            {{ $slot }}
        </div>
    </div>

</main>
