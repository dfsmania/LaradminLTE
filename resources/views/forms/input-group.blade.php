{{-- Form group structure --}}
<div class="{{ $formGroupClasses }}">

    {{-- Input group label (non-floating mode) --}}
    @if(! empty($label) && ! $floatingLabelMode)
        <label for="{{ $inputName }}" class="{{ $labelClasses }}">
            {{ $label }}
        </label>
    @endif

    {{-- Input group --}}
    <div class="{{ $inputGroupClasses }}">

        {{-- Input prepend slot --}}
        @if(! empty($prepend))
            {{ $prepend }}
        @endif

        {{-- Slot for the underlying input element --}}
        @if(! empty($label) && $floatingLabelMode)
            <div class="form-floating">
                {{ $slot }}

                {{-- Input group label (floating mode) --}}
                <label for="{{ $inputName }}" class="{{ $labelClasses }}">
                    {{ $label }}
                </label>
            </div>
        @else
            {{ $slot }}
        @endif

        {{-- Input append slot --}}
        @if(! empty($append))
            {{ $append }}
        @endif

    </div>

    {{-- Form text (tooltip or help) --}}
    @if(! empty($help))
        <div class="form-text">{{ $help }}</div>
    @endif

    {{-- Validation error feedback --}}
    @if($useValidationFeedback)
        @error($errorKey)
            <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </div>
        @elseif(session()->has('errors'))
            {{-- TODO: Implement valid feedback --}}
            {{-- Text might be set in the component or default value from language files --}}
            {{--
            <div class="valid-feedback">
                <strong>{{ $validFeedback ?? 'Looks good!' }}</strong>
            </div>
            --}}
        @enderror
    @endif

</div>
