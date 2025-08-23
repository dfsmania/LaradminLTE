<?php

namespace DFSmania\LaradminLte\View\Forms;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    // TODO: Implement next trait.
    // use Traits\OldValueSupportTrait;

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
     * Create a new component instance.
     *
     * @param  string  $name  The name attribute of the input element
     * @param  ?string  $id  The id attribute of the input element
     * @return void
     */
    public function __construct(string $name, ?string $id = null)
    {
        $this->name = $name;
        $this->id = $id ?? $name;
    }

    /**
     * Resolve base classes depending on validation state.
     *
     * @param  ViewErrorBag  $errors  The errors bag instance
     * @return string
     */
    public function getBaseClasses(ViewErrorBag $errors): string
    {
        $classes = ['form-control'];

        if ($errors->has($this->name)) {
            $classes[] = 'is-invalid';
        } elseif (! $errors->isEmpty()) {
            $classes[] = 'is-valid';
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
