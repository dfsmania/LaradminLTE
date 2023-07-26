{{-- Plugins files --}}

@foreach($files as $file)

    {{-- TODO: Render the file --}}
    {{-- TODO: Create components to handle plugin links and scripts --}}
    {{-- TODO: Additional properties may be bypassed using $attributes->merge() --}}

    @if($type === 'pre-adminlte-css' || $type === 'post-adminlte-css')
        <link ladmin="test" rel="stylesheet" href="{{ $file['location'] }}">
    @elseif($type === 'pre-adminlte-js' || $type === 'post-adminlte-js')
        <script ladmin="test" src="{{ $file['location'] }}"></script>
    @endif

@endforeach
