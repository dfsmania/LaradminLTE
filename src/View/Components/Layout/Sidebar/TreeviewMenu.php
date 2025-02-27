<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;

class TreeviewMenu extends Component
{
    /**
     * The text for the badge of the treeview menu.
     *
     * @var string
     */
    public $badge;

    /**
     * A set of extra classes for the badge. You may use this to customize the
     * badge style.
     *
     * @var string
     */
    public $badgeClasses;

    /**
     * The AdminLTE theme for the badge (primary, secondary, info, success,
     * warning, danger, light, dark, black, white).
     *
     * @var string
     */
    public $badgeTheme;

    /**
     * The Font Awesome icon of the treeview menu.
     *
     * @var string
     */
    public $icon;

    /**
     * The label of the treeview menu.
     *
     * @var string
     */
    public $label;

    /**
     * The AdminLTE theme for the treeview menu (primary, secondary, info,
     * success, warning, danger, light, dark, black, white).
     *
     * @var string
     */
    public $theme;

    /**
     * The Font Awesome icon of the treeview menu toggler.
     *
     * @var string
     */
    public $togglerIcon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label, $icon = null, $theme = null, $badge = null,
        $badgeTheme = 'secondary', $badgeClasses = null,
        $togglerIcon = 'fa-solid fa-angle-right'
    ) {
        $this->label = html_entity_decode($label);
        $this->icon = $icon;
        $this->theme = $theme;
        $this->badge = html_entity_decode($badge);
        $this->badgeTheme = $badgeTheme;
        $this->badgeClasses = $badgeClasses;
        $this->togglerIcon = $togglerIcon;
    }

    /**
     * Make the set of classes for the link.
     *
     * @return string
     */
    public function makeLinkClasses()
    {
        $classes = ['nav-link', 'user-select-none'];

        if (! empty($this->theme)) {
            $classes[] = "text-{$this->theme}";
        }

        return implode(' ', $classes);
    }

    /**
     * Make the set of classes for the badge.
     *
     * @return string
     */
    public function makeBadgeClasses()
    {
        $classes = ['nav-badge', 'badge', 'fw-bold', 'me-3'];

        $classes[] = "bg-{$this->badgeTheme}";

        if (! empty($this->badgeClasses)) {
            $classes[] = $this->badgeClasses;
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.sidebar.treeview-menu');
    }
}
