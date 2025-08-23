{{-- Input element --}}
<input id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => $getBaseClasses($errors)]) }}/>
