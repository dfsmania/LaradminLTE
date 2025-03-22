{{-- Body / Script resources --}}
@foreach($resources as $res)
    <script {!! $computeResourceAttributes($res) !!}></script>
@endforeach
