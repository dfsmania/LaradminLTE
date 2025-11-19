<?php

namespace DFSmania\LaradminLte\View\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Sidebar extends Component
{
    /**
     * The set of valid Bootstrap themes that can be applied to the sidebar.
     *
     * @var array
     */
    protected $validBootstrapThemes = [
        'light',
        'dark',
    ];

    /**
     * The set of CSS classes that will be applied to the sidebar wrapper, as a
     * space-separated string
     *
     * @var string
     */
    public string $sidebarClasses;

    /**
     * The Bootstrap theme that will be applied to the sidebar wrapper.
     *
     * @var string
     */
    public string $bootstrapTheme;

    /**
     * The set of CSS classes that will be applied to the sidebar brand text,
     * as a space-separated string
     *
     * @var string
     */
    public string $brandTextClasses;

    /**
     * The set of CSS classes that will be applied to the sidebar brand image,
     * as a space-separated string
     *
     * @var string
     */
    public string $brandImageClasses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sidebarClasses = $this->getSidebarClasses();
        $this->bootstrapTheme = $this->getBootstrapTheme();
        $this->brandTextClasses = $this->getBrandTextClasses();
        $this->brandImageClasses = $this->getBrandImageClasses();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::layout.sidebar.sidebar');
    }

    /**
     * Gets the set of CSS classes for the sidebar wrapper.
     *
     * @return string
     */
    protected function getSidebarClasses(): string
    {
        // Setup base sidebar classes.

        $classes = ['app-sidebar'];

        // Add extra classes from the configuration file.

        $cfgClasses = config('ladmin.main.sidebar.classes', [
            'bg-body-secondary',
        ]);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, array_filter($cfgClasses));
        }

        // Return the classes as a space-separated string.

        return implode(' ', $classes);
    }

    /**
     * Gets the specific Bootstrap theme for the sidebar wrapper.
     *
     * @return string
     */
    protected function getBootstrapTheme(): string
    {
        $bsTheme = config('ladmin.main.sidebar.bootstrap_theme', 'dark');

        return in_array($bsTheme, $this->validBootstrapThemes) ? $bsTheme : '';
    }

    /**
     * Gets the set of CSS classes for the sidebar brand logo text.
     *
     * @return string
     */
    protected function getBrandTextClasses(): string
    {
        // Retrieve classes from the configuration file, defaulting to an empty
        // array if not set.

        $cfgClasses = config('ladmin.main.logo.text_classes', []);

        // Return the classes as a space-separated string.

        return is_array($cfgClasses)
            ? implode(' ', array_filter($cfgClasses))
            : '';
    }

    /**
     * Gets the set of CSS classes for the sidebar brand logo image.
     *
     * @return string
     */
    protected function getBrandImageClasses(): string
    {
        // Retrieve classes from the configuration file, defaulting to an empty
        // array if not set.

        $cfgClasses = config('ladmin.main.logo.image_classes', []);

        // Return the classes as a space-separated string.

        return is_array($cfgClasses)
            ? implode(' ', array_filter($cfgClasses))
            : '';
    }
}
