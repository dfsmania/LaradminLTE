{{-- Profile section component --}}
<div class="row my-4">

    {{-- Section description --}}
    <div class="col-12 col-md-6">
        <h3>{{ $title }}</h3>
        <p class="text-muted">{{ $description }}</p>
    </div>

    {{-- Section content --}}
    <div class="col-12 col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>

</div>
