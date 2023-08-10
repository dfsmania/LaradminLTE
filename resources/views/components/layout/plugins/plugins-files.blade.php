{{-- Plugins files --}}

@foreach($files as $file)

    {{--
    TODO: Rework file type, client may just specify pre or post adminlte and
    we can guess the file extension. For this we can use pathinfo() PHP method
    --}}

    @if($type === 'pre-adminlte-css' || $type === 'post-adminlte-css')
        <link {!! $computePluginFileAttributes($file, 'css') !!}/>
    @elseif($type === 'pre-adminlte-js' || $type === 'post-adminlte-js')
        <script {!! $computePluginFileAttributes($file, 'js') !!}></script>
    @endif

@endforeach
