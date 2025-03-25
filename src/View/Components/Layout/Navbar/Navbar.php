<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Navbar extends Component
{
    /**
     * The set of valid Bootstrap themes that can be applied on the navbar.
     *
     * @var array
     */
    protected $validBootstrapThemes = [
        'light',
        'dark'
    ];

    /**
     * Make the set of classes for the navbar wrapper.
     *
     * @return string
     */
    public function makeNavbarClasses(): string
    {
        // Setup base navbar classes.

        $classes = ['app-header', 'navbar', 'navbar-expand'];

        // TODO: When support to layout topnav is implemented in AdminLTE 4, we
        // should allow the user to choose the screen breakpoint for the
        // navbar-expand class from the configuration file, like
        // 'navbar-expand-md' or 'navbar-expand-lg'. See more info at:
        // https://getbootstrap.com/docs/5.3/components/navbar/#responsive-behaviors

        // Add extra classes from the configuration file.

        $cfgClasses = config('ladmin.navbar.classes', ['bg-body']);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, $cfgClasses);
        }

        return implode(' ', $classes);
    }

    /**
     * Make the specific Bootstrap theme for the navbar wrapper.
     *
     * @return string
     */
    public function makeBootstrapTheme(): string
    {
        $bsTheme = config('ladmin.navbar.bootstrap_theme', '');

        return in_array($bsTheme, $this->validBootstrapThemes) ? $bsTheme : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.navbar.navbar');
    }
}
