<?php

namespace DFSmania\LaraliveAdmin\View\Components\Layout\Sidebar;

use Illuminate\View\Component;

/**
 * TODO: Should we use a Livewire component instead?
 */
class Sidebar extends Component
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
     * Make the set of classes for the sidebar wrapper.
     *
     * @return string
     */
    public function makeSidebarClasses()
    {
        // TODO: This logic should be improved based on the package
        // configuration. For example, the sidebar may be themed with
        // different classes.

        $classes = ['app-sidebar', 'bg-body-secondary', 'shadow'];

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.sidebar.sidebar');
    }
}
