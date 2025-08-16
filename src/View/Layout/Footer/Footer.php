<?php

namespace DFSmania\LaradminLte\View\Layout\Footer;

use Illuminate\View\Component;
use Illuminate\View\View;

class Footer extends Component
{
    /**
     * The set of CSS classes that will be applied to the footer wrapper, as a
     * space-separated string
     *
     * @var string
     */
    public string $footerClasses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->footerClasses = $this->getFooterClasses();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::layout.footer.footer');
    }

    /**
     * Gets the set of CSS classes for the footer wrapper.
     *
     * @return string
     */
    protected function getFooterClasses(): string
    {
        // Setup base footer classes.

        $classes = ['app-footer'];

        // Add extra classes from the configuration file.

        $cfgClasses = config('ladmin.footer.classes', ['bg-body']);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, array_filter($cfgClasses));
        }

        // Return the classes as a space-separated string.

        return implode(' ', $classes);
    }
}
