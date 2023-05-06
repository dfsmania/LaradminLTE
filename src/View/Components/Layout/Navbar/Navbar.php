<?php

namespace DFSmania\LaraliveAdmin\View\Components\Layout\Navbar;

use Illuminate\View\Component;

/**
 * TODO: Should we use a Livewire component instead?
 */
class Navbar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Make the set of classes for the navbar wrapper.
     *
     * @return string
     */
    public function makeNavbarClasses()
    {
        // TODO: This logic should be improved based on the package
        // configuration. For example, the navbar may be themed with classes:
        // navbar-light/dark and bg-* classes.

        $classes = ['app-header', 'navbar', 'navbar-expand', 'bg-body'];

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.navbar.navbar');
    }
}
