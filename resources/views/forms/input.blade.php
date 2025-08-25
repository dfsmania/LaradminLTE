{{-- Input element --}}
<input id="{{ $id }}" name="{{ $name }}"
    value="{{ $resolveOldInput($errorKey, $attributes->get('value')) }}"
    {{ $attributes->merge(['class' => $getBaseClasses($errors)]) }}/>
