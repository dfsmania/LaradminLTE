<?php

namespace DFSmania\LaradminLte\View\Forms;

use DFSmania\LaradminLte\View\Forms\Traits\HandlesOldInput;
use DFSmania\LaradminLte\View\Forms\Traits\ResolvesErrorKey;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    use HandlesOldInput, ResolvesErrorKey;

    /**
     * The id attribute of the input element.
     *
     * @var string
     */
    public string $id;

    /**
     * The name attribute of the input element, also used as the default "id"
     * attribute when no other is provided.
     *
     * @var string
     */
    public string $name;

    /**
     * Whether to show validation feedback style on the input element. This is
     * useful when the input is used in a form that requires validation.
     *
     * @var bool
     */
    public bool $useValidationFeedback;

    /**
     * Create a new component instance.
     *
     * @param  string  $name  The name attribute of the input element
     * @param  ?string  $id  The id attribute of the input element
     * @param  bool  $noOldInput  Whether to disable old input support
     * @return void
     */
    public function __construct(
        string $name,
        ?string $id = null,
        bool $noOldInput = false,
        bool $noValidationFeedback = false
    ) {
        $this->name = $name;
        $this->id = $id ?? $name;

        // Setup whether to use old input values (this is handled by the
        // HandlesOldInput trait).

        $this->useOldInput = ! $noOldInput;

        // Setup whether to use validation feedback.

        $this->useValidationFeedback = ! $noValidationFeedback;

        // Resolve the lookup key for validation errors. Note this
        // initialization uses a dedicated Trait method.

        $this->resolveErrorKey($this->name);
    }

    /**
     * Resolve base classes depending on the validation state.
     *
     * @param  ViewErrorBag  $errors  The errors bag instance
     * @return string
     */
    public function getBaseClasses(ViewErrorBag $errors): string
    {
        $classes = ['form-control'];

        if ($this->useValidationFeedback) {
            if ($errors->has($this->errorKey)) {
                $classes[] = 'is-invalid';
            } elseif (! $errors->isEmpty()) {
                $classes[] = 'is-valid';
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::forms.input');
    }
}
