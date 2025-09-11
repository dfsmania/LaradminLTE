{{-- Textarea element --}}
<textarea id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => $getBaseClasses($errors)]) }}
>{{ $resolveOldInput($errorKey, $slot) }}</textarea>
