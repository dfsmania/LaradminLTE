<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Footer;

use Illuminate\View\Component;
use Illuminate\View\View;

class Footer extends Component
{
    /**
     * The set of valid Bootstrap themes that can be applied on the footer.
     *
     * @var array
     */
    protected $validBootstrapThemes = [
        'light',
        'dark'
    ];

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
            $classes = array_merge($classes, array_filter($cfgClasses));
        }

        // Return the classes as a space-separated string.

        return implode(' ', $classes);
    }

    /**
     * Make the specific Bootstrap theme for the footer wrapper.
     *
     * @return string
     */
    public function makeBootstrapTheme(): string
    {
        $bsTheme = config('ladmin.footer.bootstrap_theme', '');

        return in_array($bsTheme, $this->validBootstrapThemes) ? $bsTheme : '';
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
