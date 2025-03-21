<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Link extends Component
{
    /**
     * The text for the badge of the link.
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
     * The Font Awesome icon of the link.
     *
     * @var string
     */
    public $icon;

    /**
     * The label of the link.
     *
     * @var string
     */
    public $label;

    /**
     * The AdminLTE theme for the link (primary, secondary, info, success,
     * warning, danger, light, dark, black, white).
     *
     * @var string
     */
    public $theme;

    /**
     * The URL of the link.
     *
     * @var string
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $label,
        ?string $icon = null,
        string $url = '#',
        ?string $theme = null,
        ?string $badge = null,
        string $badgeTheme = 'secondary',
        ?string $badgeClasses = null
    ) {
        $this->label = html_entity_decode($label);
        $this->icon = $icon;
        $this->url = $url;
        $this->theme = $theme;
        $this->badge = html_entity_decode($badge);
        $this->badgeTheme = $badgeTheme;
        $this->badgeClasses = $badgeClasses;
    }

    /**
     * Make the set of classes for the link.
     *
     * @return string
     */
    public function makeLinkClasses(): string
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
    public function makeBadgeClasses(): string
    {
        $classes = ['nav-badge', 'badge', 'fw-bold'];
        $classes[] = "bg-{$this->badgeTheme}";

        if (! empty($this->badgeClasses)) {
            $classes[] = $this->badgeClasses;
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('ladmin::components.layout.sidebar.link');
    }
}
