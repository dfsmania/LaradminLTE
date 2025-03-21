<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

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
    public function makeSidebarClasses(): string
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
    public function render(): View|string
    {
        return view('ladmin::components.layout.sidebar.sidebar');
    }
}
