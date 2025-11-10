<?php

namespace DFSmania\LaradminLte\View\Forms;

use DFSmania\LaradminLte\View\Forms\Abstracts\BaseFormInput;
use Illuminate\Support\ViewErrorBag;

class Checkbox extends BaseFormInput
{
    /**
     * The default set of CSS classes applied to the input element.
     *
     * @var string[]
     */
    protected array $baseClasses = [
        'form-check-input',
        'disable-adminlte-validations',
    ];

    /**
     * The label for the checkbox element (optional). This is used to provide a
     * descriptive label for the checkbox. Note the "input-group" decorator
     * cannot be used with checkboxes, so the checkbox manages its own label.
     *
     * @var ?string
     */
    public ?string $label;

    /**
     * The set of CSS classes for the "label" element. This will hold the
     * default set of classes plus custom classes provided by the user.
     *
     * @var string
     */
    public string $labelClasses;

    /**
     * The inline style for the label element (optional). This is used to apply
     * custom styles to the label, such as font size adjustments for sizing.
     *
     * @var ?string
     */
    public ?string $labelStyle;

    /**
     * The base inline style for the checkbox input element (optional). This is
     * used to apply custom styles to the checkbox, such as scaling for sizing.
     *
     * @var ?string
     */
    public ?string $checkboxStyle;

    /**
     * Whether the checkbox is rendered as a Bootstrap switch. A switch is a
     * styled checkbox that is typically used for toggling settings.
     *
     * @var bool
     */
    public bool $isSwitch;

    /**
     * Create a new component instance.
     *
     * @param  string  $name  The name attribute of the checkbox element
     * @param  ?string  $id  The id attribute of the checkbox element
     * @param  ?string  $sizing  The size modifier for the checkbox element
     * @param  bool  $noOldInput  Whether to disable old input support
     * @param  bool  $noValidationFeedback  Whether to disable validation feedback
     * @param  ?string  $label  The label for the checkbox element
     * @param  ?string  $labelClasses  Custom classes for the label element
     * @param  bool  $switchMode  Whether to render the checkbox as a switch
     * @return void
     */
    public function __construct(
        string $name,
        ?string $id = null,
        ?string $sizing = null,
        bool $noOldInput = false,
        bool $noValidationFeedback = false,
        ?string $label = null,
        ?string $labelClasses = null,
        bool $switchMode = false
    ) {
        // Call the parent constructor to initialize base properties. Note that
        // sizing will be handled in a special way since checkboxes do not have
        // specific Bootstrap sizing classes. So we avoid passing it to the
        // parent.

        parent::__construct(
            name: $name,
            id: $id,
            sizing: null,
            noOldInput: $noOldInput,
            noValidationFeedback: $noValidationFeedback
        );

        // Setup whether the checkbox should be rendered as a switch.

        $this->isSwitch = $switchMode;

        // If a label is provided, use html_entity_decode() method to support
        // HTML entities in the label text. Otherwise, set it to null.

        $this->label = ! empty($label) ? html_entity_decode($label) : null;

        // Setup the set of CSS classes for the label element. This includes
        // the default classes plus any custom classes provided by the user.

        $this->labelClasses = $this->getLabelClasses($labelClasses);

        // Handle sizing for the checkbox. Since checkboxes do not have
        // specific Bootstrap sizing classes, we will apply custom styles
        // based on the provided sizing option.

        $styles = $this->resolveSizingStyles($sizing);
        $this->labelStyle = $styles['label'];
        $this->checkboxStyle = $styles['checkbox'];
    }

    /**
     * Determine if the checkbox should be rendered as checked. This first
     * checks if there are validation errors (indicating a form submission). If
     * so, it uses the old input value to determine the checked state. If there
     * are no validation errors (initial rendering case), it falls back to
     * checking if the "checked" attribute is present in the attributes bag.
     *
     * @param  ViewErrorBag  $errors  The errors bag instance
     * @return bool
     */
    public function isChecked(ViewErrorBag $errors): bool
    {
        return $errors->any()
            ? (bool) $this->resolveOldInput($this->errorKey)
            : $this->attributes->has('checked');
    }

    /**
     * Get the set of CSS classes for the "label" element.
     *
     * @param  ?string  $classes  Set of custom classes to be added
     * @return string
     */
    protected function getLabelClasses(?string $classes = null): string
    {
        $classesArray = ['form-check-label', 'ms-1'];

        // Add any custom classes provided by the user.

        if (! empty($classes)) {
            $classesArray[] = trim($classes);
        }

        return implode(' ', $classesArray);
    }

    /**
     * Resolve inline styles for sizing adjustments based on the provided
     * sizing option. This method returns an array with styles for both the
     * label and the checkbox input element.
     *
     * @param  ?string  $sizing  The size modifier ('sm', 'lg', or null)
     * @return array
     */
    protected function resolveSizingStyles(?string $sizing = null): array
    {
        return match ($sizing) {
            'sm' => [
                'label' => 'font-size:0.875rem;',
                'checkbox' => 'transform:scale(0.85);',
            ],
            'lg' => [
                'label' => 'font-size:1.25rem;',
                'checkbox' => 'transform:scale(1.3);margin-top:0.45rem;',
            ],
            default => [
                'label' => null,
                'checkbox' => null,
            ],
        };
    }

    /**
     * Get the name of the Blade view that represents the component.
     * Each child must return its specific Blade view.
     *
     * @return string
     */
    protected function viewName(): string
    {
        return 'ladmin::forms.checkbox';
    }
}
