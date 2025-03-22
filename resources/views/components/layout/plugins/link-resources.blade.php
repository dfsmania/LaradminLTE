{{-- Head / Link resources --}}
@foreach($resources as $res)
    <link {!! $computeResourceAttributes($res) !!}>
@endforeach
