<?php

namespace DFSmania\LaradminLte\View\Forms;

use DFSmania\LaradminLte\View\Forms\Abstracts\BaseFormInput;

class Select extends BaseFormInput
{
    /**
     * The default set of CSS classes applied to the input element.
     *
     * @var string[]
     */
    protected array $baseClasses = [
        'form-select',
        'disable-adminlte-validations',
    ];

    /**
     * The set of options for the select element. Each option is represented
     * by an array with next properties:
     * - value: The value attribute of the option.
     * - label: The display text of the option.
     * - selected: Whether the option is selected.
     * - disabled: Whether the option is disabled.
     *
     * @var array<int, array<string, mixed>>
     */
    public array $options;

    /**
     * Create a new component instance.
     *
     * @param  string  $name  The name attribute of the select element
     * @param  ?string  $id  The id attribute of the select element
     * @param  ?string  $sizing  The size modifier for the select element
     * @param  bool  $noOldInput  Whether to disable old input support
     * @param  bool  $noValidationFeedback  Whether to disable validation feedback
     * @param  array  $options  The set of options for the select element
     * @return void
     */
    public function __construct(
        string $name,
        ?string $id = null,
        ?string $sizing = null,
        bool $noOldInput = false,
        bool $noValidationFeedback = false,
        array $options = []
    ) {
        // Call the parent constructor to initialize base properties.

        parent::__construct(
            name: $name,
            id: $id,
            sizing: $sizing,
            noOldInput: $noOldInput,
            noValidationFeedback: $noValidationFeedback
        );

        // Setup the options for the select element, with normalization and
        // automatic selection handling based on old input.

        $this->options = $this->getNormalizedOptions($options);
    }

    /**
     * Get the name of the Blade view that represents the component.
     * Each child must return its specific Blade view.
     *
     * @return string
     */
    protected function viewName(): string
    {
        return 'ladmin::forms.select';
    }

    /**
     * Normalize the options array to ensure each option has the required
     * properties and determine selection state based on old input.
     *
     * @param  array<int, array<string, mixed>>  $options
     * @return array<int, array<string, mixed>>
     */
    protected function getNormalizedOptions(array $options): array
    {
        // Determine if there are validation errors present.

        $hasErrors = session()->has('errors');

        // Determine old selected values. If old input support is disabled,
        // this will be an empty collection.

        $oldSelectedValues = collect($this->resolveOldInput($this->errorKey));

        // Normalize options to ensure each has the required properties. This
        // also handles selection state based on old input. When there are
        // validation errors, the old selected values will always be used.
        // Otherwise, the 'selected' property from the options array will be
        // used, if present.

        $normalizedOptions = [];

        foreach ($options as $opt) {
            if (! $this->isValidOption($opt)) {
                continue;
            }

            $value = $opt['value'] ?? '';
            $isSelected = $hasErrors
                ? $oldSelectedValues->contains($value)
                : ! empty($opt['selected']);

            $normalizedOptions[] = [
                'value' => $value,
                'label' => $opt['label'] ?? $value,
                'selected' => $isSelected,
                'disabled' => ! empty($opt['disabled']),
            ];
        }

        return $normalizedOptions;
    }

    /**
     * Check if the given option array is valid by checking for the presence
     * of required keys.
     *
     * @param  array<string, mixed>  $option
     * @return bool
     */
    protected function isValidOption(array $option): bool
    {
        return array_key_exists('value', $option)
            && is_string($option['value']);
    }
}
