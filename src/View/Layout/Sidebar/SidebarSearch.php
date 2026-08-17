<?php

namespace DFSmania\LaradminLte\View\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class SidebarSearch extends Component
{
    /**
     * The target element selector for the sidebar search input. This is used
     * to specify which part of the sidebar the search input will filter. It
     * should be a valid CSS selector that points to the container of the menu
     * items to be filtered.
     *
     * @var string
     */
    public string $target;

    /**
     * Create a new component instance.
     *
     * @param  ?string  $target  The target element selector for the sidebar
     *                           search input.
     * @return void
     */
    public function __construct(?string $target = null)
    {
        $this->target = $target ?? 'ul.sidebar-menu';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::layout.sidebar.sidebar-search');
    }
}
