<?php

namespace DFSmania\LaradminLte\View\Forms;

use Illuminate\View\Component;
use Illuminate\View\View;

class InputGroup extends Component
{
    /**
     * The name attribute of the underlying input element. This is required to
     * detect validation errors. An input group should always be associated
     * with a specific input element.
     *
     * @var string
     */
    public string $inputName;

    /**
     * The label for the input group (optional). This is used to provide a
     * descriptive label for the underlying input element.
     *
     * @var ?string
     */
    public ?string $label;

    /**
     * The set of CSS classes for the "form-group" (main wrapper) element. This
     * will hold the default set of classes plus custom classes provided by the
     * user.
     *
     * @var string
     */
    public string $formGroupClasses;

    /**
     * The set of CSS classes for the "label" element. This will hold the
     * default set of classes plus custom classes provided by the user.
     *
     * @var string
     */
    public string $labelClasses;

    /**
     * The set of CSS classes for the "input-group" element. This will hold
     * the default set of classes plus custom classes provided by the user.
     *
     * @var string
     */
    public string $inputGroupClasses;

    /**
     * The lookup key to use when searching for validation errors inside the
     * errors bag. The lookup key will be generated from the "inputName"
     * property.
     *
     * @var string
     */
    public string $errorKey;

    /**
     * Create a new component instance.
     *
     * @param  string  $for  A reference to the name of the input element
     * @param  ?string  $label  The label for the input group
     * @param  ?string  $igroupSize  The size of the input group
     * @param  ?string  $labelClasses  Custom classes for the label element
     * @param  ?string  $fgroupClasses  Custom classes for the "form-group"
     * @param  ?string  $igroupClasses  Custom classes for the "input-group"
     * @return void
     */
    public function __construct(
        string $for,
        ?string $label = null,
        ?string $igroupSize = null,
        ?string $labelClasses = null,
        ?string $fgroupClasses = null,
        ?string $igroupClasses = null
    ) {
        $this->inputName = $for;

        // If a label is provided, use html_entity_decode() method to support
        // HTML entities in the label text. Otherwise, set it to null.

        $this->label = ! empty($label) ? html_entity_decode($label) : null;

        // Setup the size of the input group. It can be 'sm', 'lg', or null
        // for default sizing. The size is validated to ensure it is one of the
        // allowed values.

        $size = in_array($igroupSize, ['sm', 'lg']) ? $igroupSize : null;

        // Setup the lookup key for validation errors.

        $this->errorKey = $this->getErrorKeyFromName();

        // Set the CSS classes for the "form-group", "input-group" and label
        // elements.

        $this->formGroupClasses = $this->getFormGroupClasses($fgroupClasses);
        $this->labelClasses = $this->getLabelClasses($labelClasses);

        $this->inputGroupClasses = $this->getInputGroupClasses(
            $size,
            $igroupClasses
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::forms.input-group');
    }

    /**
     * Get the set of CSS classes for the "form-group" element. The form group
     * element is the main container for the input group, its label, and any
     * validation feedback.
     *
     * @param  ?string  $classes  Set of custom classes to be added
     * @return string
     */
    protected function getFormGroupClasses(?string $classes = null): string
    {
        $classesArray = ['mb-3'];

        if (! empty($classes)) {
            $classesArray[] = trim($classes);
        }

        return implode(' ', $classesArray);
    }

    /**
     * Get the set of CSS classes for the "label" element.
     *
     * @param  ?string  $classes  Set of custom classes to be added
     * @return string
     */
    protected function getLabelClasses(?string $classes = null): string
    {
        $classesArray = ['form-label'];

        if (! empty($classes)) {
            $classesArray[] = trim($classes);
        }

        return implode(' ', $classesArray);
    }

    /**
     * Get the set of CSS classes for the "input-group" element.
     *
     * @param  ?string  $size  The size of the input group element
     * @param  ?string  $classes  Set of custom classes to be added
     * @return string
     */
    protected function getInputGroupClasses(
        ?string $size = null,
        ?string $classes = null
    ): string {

        $classesArray = ['input-group'];

        if (! empty($size)) {
            $classesArray[] = "input-group-{$size}";
        }

        if (! empty($classes)) {
            $classesArray[] = $classes;
        }

        return implode(' ', $classesArray);
    }

    /**
     * Gets the error key that will be used to search for validation errors.
     * The error key is generated from the 'name' property.
     * Examples:
     * $name = 'files[]'         => $errorKey = 'files'.
     * $name = 'person[2][name]' => $errorKey = 'person.2.name'.
     *
     * @return string
     */
    protected function getErrorKeyFromName(): string
    {
        $errKey = preg_replace('@\[\]$@', '', $this->inputName);

        return preg_replace('@\[([^]]+)\]@', '.$1', $errKey);
    }
}
