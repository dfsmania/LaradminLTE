<?php

namespace DFSmania\LaradminLte\View\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Navbar extends Component
{
    /**
     * The set of CSS classes that will be applied to the navbar wrapper, as a
     * space-separated string
     *
     * @var string
     */
    public string $navbarClasses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->navbarClasses = $this->getNavbarClasses();
    }

    /**
     * Gets the set of CSS classes for the navbar wrapper.
     *
     * @return string
     */
    protected function getNavbarClasses(): string
    {
        // Setup base navbar CSS classes.

        $classes = ['app-header', 'navbar', 'navbar-expand'];

        // TODO: When support to layout topnav is implemented in AdminLTE 4, we
        // should allow the user to choose the screen breakpoint for the
        // navbar-expand class from the configuration file, like
        // 'navbar-expand-md' or 'navbar-expand-lg'. See more info at:
        // https://getbootstrap.com/docs/5.3/components/navbar/#responsive-behaviors

        // Add extra CSS classes from the configuration file.

        $cfgClasses = config('ladmin.navbar.classes', ['bg-body']);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, array_filter($cfgClasses));
        }

        // Return the classes as a space-separated string.

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::layout.navbar.navbar');
    }
}
