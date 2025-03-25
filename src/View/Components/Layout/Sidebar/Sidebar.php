<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Sidebar extends Component
{
    /**
     * The set of valid Bootstrap themes that can be applied on the sidebar.
     *
     * @var array
     */
    protected $validBootstrapThemes = [
        'light',
        'dark'
    ];

    /**
     * Make the set of classes for the sidebar wrapper.
     *
     * @return string
     */
    public function makeSidebarClasses(): string
    {
        // Setup base sidebar classes.

        $classes = ['app-sidebar'];

        // Add extra classes from the configuration file.

        $cfgClasses = config('ladmin.sidebar.classes', ['bg-body-secondary']);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, $cfgClasses);
        }

        return implode(' ', $classes);
    }

    /**
     * Make the specific Bootstrap theme for the sidebar wrapper.
     *
     * @return string
     */
    public function makeBootstrapTheme(): string
    {
        $bsTheme = config('ladmin.sidebar.bootstrap_theme', 'dark');

        return in_array($bsTheme, $this->validBootstrapThemes) ? $bsTheme : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.sidebar.sidebar');
    }
}
