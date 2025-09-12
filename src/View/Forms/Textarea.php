<?php

namespace DFSmania\LaradminLte\View\Forms;

use DFSmania\LaradminLte\View\Forms\Abstracts\BaseFormInput;

class Textarea extends BaseFormInput
{
    /**
     * Get the name of the Blade view that represents the component.
     * Each child must return its specific Blade view.
     *
     * @return string
     */
    protected function viewName(): string
    {
        return 'ladmin::forms.textarea';
    }
}
