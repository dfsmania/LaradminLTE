<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Navbar extends Component
{
    /**
     * The set of valid Bootstrap themes that can be applied to the navbar.
     *
     * @var string[]
     */
    protected array $validBootstrapThemes = [
        'light',
        'dark'
    ];

    /**
     * The set of classes that will be applied to the navbar wrapper, as a
     * space-separated string
     *
     * @var string
     */
    public string $navbarClasses;

    /**
     * The Bootstrap theme that will be applied to the navbar wrapper.
     *
     * @var string
     */
    public string $bootstrapTheme;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->navbarClasses = $this->getNavbarClasses();
        $this->bootstrapTheme = $this->getBootstrapTheme();
    }

    /**
     * Gets the set of classes for the navbar wrapper.
     *
     * @return string
     */
    protected function getNavbarClasses(): string
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
            $classes = array_merge($classes, array_filter($cfgClasses));
        }

        // Return the classes as a space-separated string.

        return implode(' ', $classes);
    }

    /**
     * Gets the specific Bootstrap theme for the navbar wrapper.
     *
     * @return string
     */
    protected function getBootstrapTheme(): string
    {
        $bsTheme = config('ladmin.navbar.bootstrap_theme', '');

        return in_array($bsTheme, $this->validBootstrapThemes) ? $bsTheme : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.navbar.navbar');
    }
}
