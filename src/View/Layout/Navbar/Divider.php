<?php

namespace DFSmania\LaradminLte\View\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Divider extends Component
{
    /**
     * The set of CSS classes for the divider, as a space-separated string.
     *
     * @var string
     */
    public string $dividerClasses;

    /**
     * Create a new component instance.
     *
     * @param  ?string  $color  The Bootstrap color of the divider
     * @return void
     */
    public function __construct(?string $color = null)
    {
        $this->dividerClasses = $this->getDividerClasses($color);
    }

    /**
     * Gets the set of CSS classes for the divider.
     *
     * @param  ?string  $color  The Bootstrap color for the divider
     * @return string
     */
    protected function getDividerClasses(?string $color): string
    {
        $classes = ['vr'];

        if (! empty($color)) {
            $classes[] = "bg-{$color}";
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
        return view('ladmin::layout.navbar.divider');
    }
}
