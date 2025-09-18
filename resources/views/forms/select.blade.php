{{-- Select element --}}
<select id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => $getBaseClasses($errors)]) }}>

    {{-- Render normalized options --}}
    @foreach ($options as $opt)
        <option value="{{ $opt['value'] }}" @selected($opt['selected']) @disabled($opt['disabled'])>
            {{ $opt['label'] }}
        </option>
    @endforeach

    {{-- Slot for additional or custom options --}}
    {{ $slot }}

</select>
