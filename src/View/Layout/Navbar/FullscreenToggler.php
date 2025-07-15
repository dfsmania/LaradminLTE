<?php

namespace DFSmania\LaradminLte\View\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\View\View;

class FullscreenToggler extends Component
{
    /**
     * Icon displayed when the screen is in fullscreen mode. This icon is shown
     * to allow the user to exit fullscreen mode.
     *
     * @var string
     */
    public string $iconCollapse;

    /**
     * Icon displayed when the screen is not in fullscreen mode. This icon is
     * shown to allow the user to enter fullscreen mode.
     *
     * @var string
     */
    public string $iconExpand;

    /**
     * The set of CSS classes for the fullscreen toggler link, as a
     * space-separated string.
     *
     * @var string
     */
    public string $linkClasses;

    /**
     * Create a new component instance.
     *
     * @param  string  $iconCollapse  The icon for exit fullscreen state
     * @param  string  $iconExpand  The icon for enter fullscreen state
     * @param  ?string  $color  The Bootstrap color of the toggler
     * @return void
     */
    public function __construct(
        string $iconCollapse,
        string $iconExpand,
        ?string $color = null
    ) {
        $this->iconCollapse = $iconCollapse;
        $this->iconExpand = $iconExpand;
        $this->linkClasses = $this->getLinkClasses($color);
    }

    /**
     * Gets the set of CSS classes for the fullscreen toggler link.
     *
     * @param  ?string  $color  The Bootstrap color for the toggler link
     * @return string
     */
    protected function getLinkClasses(?string $color): string
    {
        $classes = ['nav-link', 'd-flex', 'align-items-center'];

        if (! empty($color)) {
            $classes[] = "link-{$color}";
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
        return view('ladmin::layout.navbar.fullscreen-toggler');
    }
}
