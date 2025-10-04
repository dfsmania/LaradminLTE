{{-- Checkbox element --}}
<div class="form-check @if($isSwitch) form-switch @endif">

    {{-- Checkbox input --}}
    <input id="{{ $id }}" name="{{ $name }}" type="checkbox" @checked($isChecked($errors))
        {{ $attributes->except('checked')->merge([
            'class' => $getBaseClasses($errors),
            'style' => $checkboxStyle,
            'role' => $isSwitch ? 'switch' : null,
        ]) }}/>

    {{-- Checkbox label --}}
    @if (! empty($label))
        <label for="{{ $id }}" class="{{ $labelClasses }}" style="{{ $labelStyle }}">
            {{ $label }}
        </label>
    @endif

</div>
