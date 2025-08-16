<?php

namespace DFSmania\LaradminLte\View\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    /**
     * The icon associated with the header (optional).
     *
     * @var ?string
     */
    public ?string $icon;

    /**
     * The label of the header.
     *
     * @var string
     */
    public string $label;

    /**
     * The set of CSS classes for the header, as a space-separated string.
     *
     * @var string
     */
    public string $headerClasses;

    /**
     * Create a new component instance.
     *
     * @param  string  $label  The label text for the header
     * @param  ?string  $icon  The icon associated with the header
     * @param  ?string  $color  The Bootstrap color of the header
     * @return void
     */
    public function __construct(
        string $label,
        ?string $icon = null,
        ?string $color = null
    ) {
        $this->label = html_entity_decode($label);
        $this->icon = $icon;
        $this->headerClasses = $this->getHeaderClasses($color);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::layout.sidebar.header');
    }

    /**
     * Gets the set of CSS classes for the header.
     *
     * @param  ?string  $color  The Bootstrap color for the header text
     * @return string
     */
    protected function getHeaderClasses(?string $color): string
    {
        // TODO: Header style should be reviewed and improved in the AdminLTE
        // 4.0 package, there's currently a overflow issue when sidebar toggles
        // between collapsed and expanded states, also maybe the display
        // property may be changed to flex as it's done with the links.
        $classes = ['nav-header'];

        if (! empty($color)) {
            $classes[] = "text-{$color}";
        }

        return implode(' ', $classes);
    }
}
