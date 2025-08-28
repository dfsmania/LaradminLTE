{{-- Form group structure --}}
<div class="{{ $formGroupClasses }}">

    {{-- Input group label --}}
    {{-- TODO: Check if we can support floating labels too --}}
    @if(! empty($label))
        <label for="{{ $inputName }}" @if(! empty($labelClasses)) class="{{ $labelClasses }}" @endif>
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
        {{ $slot }}

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
