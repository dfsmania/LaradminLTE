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
     * A set of extra classes for the badge. You may use these classes to
     * customize the badge style.
     *
     * @var array
     */
    public $badgeClasses;

    /**
     * The background theme for the badge. Any Bootstrap background color, like:
     * primary, secondary, info, success, warning, danger, etc.
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
     * The color theme for the link. Any Bootstrap link color, like: primary,
     * secondary, info, success, warning, danger, etc.
     *
     * @var string
     */
    public $theme;

    /**
     * The URL (href attribute) of the link.
     *
     * @var string
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @param  string   $label  The label of the link
     * @param  ?string  $icon  The Font Awesome icon of the link
     * @param  string   $url  The URL (href attribute) of the link
     * @param  ?string  $theme  The color theme for the link
     * @param  ?string  $badge  The text for the badge of the link
     * @param  string   $badgeTheme  The background theme for the badge
     * @param  ?string  $badgeClasses  A set of extra classes for the badge
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

        $this->badgeClasses = ! empty($badgeClasses)
            ? explode(' ', $badgeClasses)
            : [];
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
            $classes = array_merge($classes, $this->badgeClasses);
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
        return view('ladmin::components.layout.sidebar.link');
    }
}
