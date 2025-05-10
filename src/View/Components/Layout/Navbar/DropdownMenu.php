<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\View\View;

class DropdownMenu extends Component
{
    /**
     * The icon of the dropdown link toggler (optional).
     *
     * @var ?string
     */
    public ?string $icon;

    /**
     * The set of CSS classes for the dropdown menu, as a space-separated
     * string.
     *
     * @var ?string
     */
    public ?string $menuClasses;

    /**
     * The label of the dropdown link toggler (optional).
     *
     * @var ?string
     */
    public ?string $label;

    /**
     * The set of CSS classes for the dropdown link toggler, as a
     * space-separated string.
     *
     * @var string
     */
    public string $linkClasses;

    /**
     * Create a new component instance.
     *
     * @param  ?string  $label  The label of the dropdown toggler
     * @param  ?string  $icon  The icon of the dropdown toggler
     * @param  ?string  $color  The Bootstrap color for the dropdown toggler
     * @param  ?string  $menuColor  The Bootstrap background color of the menu
     * @param  ?string  $menuClasses  A set of extra CSS classes for the menu
     * @return void
     */
    public function __construct(
        ?string $label = null,
        ?string $icon = null,
        ?string $color = null,
        ?string $menuColor = null,
        ?string $menuClasses = null,
    ) {
        $this->label = html_entity_decode($label);
        $this->icon = $icon;
        $this->linkClasses = $this->getLinkClasses($color);

        // Setup the CSS classes for the dropdown menu. The menu is the one
        // that holds the children items.

        $this->menuClasses = $this->getMenuClasses($menuColor, $menuClasses);
    }

    /**
     * Gets the set of CSS classes for the dropdown link toggler.
     *
     * @param  ?string  $color  The Bootstrap color for the link toggler
     * @return string
     */
    protected function getLinkClasses(?string $color): string
    {
        $classes = ['nav-link', 'dropdown-toggle'];

        if (! empty($color)) {
            $classes[] = "text-{$color}";
        }

        return implode(' ', $classes);
    }

    /**
     * Gets the set of CSS classes for the dropdown menu that holds the
     * children items.
     *
     * @param  string   $color  The Bootstrap background color for the menu
     * @param  ?string  $extraClasses  A set of extra CSS classes for the menu
     * @return string
     */
    protected function getMenuClasses(
        ?string $color,
        ?string $extraClasses
    ): string {
        $classes = ['dropdown-menu'];

        if (! empty($color)) {
            $classes[] = "bg-{$color}";
        }

        if (! empty($extraClasses)) {
            $classes[] = trim($extraClasses);
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
        return view('ladmin::components.layout.navbar.dropdown-menu');
    }
}
