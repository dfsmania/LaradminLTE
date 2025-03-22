<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Footer;

use Illuminate\View\Component;
use Illuminate\View\View;

class Footer extends Component
{
    /**
     * Make the set of classes for the footer wrapper.
     *
     * @return string
     */
    public function makeFooterClasses(): string
    {
        // Setup base footer classes.

        $classes = ['app-footer'];

        // Add extra classes from the configuration file.

        $cfgClasses = config('ladmin.footer.classes', ['bg-body']);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, $cfgClasses);
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.footer.footer');
    }
}
