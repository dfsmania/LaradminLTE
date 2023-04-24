<?php

namespace DFSmania\LaraliveAdmin\View\Components\Layout;

use Illuminate\View\Component;

/**
 * TODO: Should we use a Livewire component instead?
 */
class AdminPanel extends Component
{
    /**
     * The title that will be displayed on a browser's window. Defaults to
     * config('app.name') when not provided.
     *
     * @var string
     */
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = null)
    {
        $this->title = $title ?? config('app.name');
    }

    /**
     * Make the set of classes for the body tag.
     *
     * @return string
     */
    public function makeBodyClasses()
    {
        // TODO: This logic should be improved based on the package
        // configuration.

        $classes = [
            'sidebar-expand-lg',
            'bg-body-tertirary',
        ];

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.admin-panel');
    }
}
