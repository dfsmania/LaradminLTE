<?php

namespace DFSmania\LaradminLte\View\Layout\MainContent;

use Illuminate\View\Component;
use Illuminate\View\View;

class MainContent extends Component
{
    /**
     * The set of CSS classes that will be applied to the main content wrapper,
     * as a space-separated string.
     *
     * @var string
     */
    public string $mainContentClasses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->mainContentClasses = $this->getMainContentClasses();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::layout.main_content.main-content');
    }

    /**
     * Gets the set of CSS classes for the main content wrapper.
     *
     * @return string
     */
    protected function getMainContentClasses(): string
    {
        // Setup base footer classes.

        $classes = ['app-main'];

        // Add extra classes from the configuration file.

        $cfgClasses = config('ladmin.main_content.classes', [
            'bg-body-tertiary',
        ]);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, array_filter($cfgClasses));
        }

        // Return the classes as a space-separated string.

        return implode(' ', $classes);
    }
}
