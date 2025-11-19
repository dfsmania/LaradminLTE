<?php

namespace DFSmania\LaradminLte\View\Layout\Scripts;

use Illuminate\View\Component;
use Illuminate\View\View;

class OverlayScrollbarsInit extends Component
{
    /**
     * The theme that will be applied to the scrollbars of the sidebar.
     *
     * @var string
     */
    public string $theme;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->theme = config('ladmin.main.sidebar.bootstrap_theme') === 'light'
            ? 'os-theme-dark'
            : 'os-theme-light';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::layout.scripts.overlay-scrollbars-init');
    }
}
