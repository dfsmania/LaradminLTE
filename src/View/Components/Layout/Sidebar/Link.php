<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Link extends Component
{
    /**
     * The text for the badge of the link (optional).
     *
     * @var ?string
     */
    public ?string $badge;

    /**
     * The set of CSS classes for the badge, as a space-separated string.
     *
     * @var ?string
     */
    public ?string $badgeClasses;

    /**
     * The Font Awesome icon of the link (optional).
     *
     * @var ?string
     */
    public ?string $icon;

    /**
     * The label of the link.
     *
     * @var string
     */
    public string $label;

    /**
     * The set of CSS classes for the link, as a space-separated string.
     *
     * @var string
     */
    public string $linkClasses;

    /**
     * The URL (href attribute) of the link.
     *
     * @var string
     */
    public string $url;

    /**
     * Create a new component instance.
     *
     * @param  string   $label  The label of the link
     * @param  ?string  $icon  The Font Awesome icon of the link
     * @param  string   $url  The URL (href attribute) of the link
     * @param  ?string  $color  The Bootstrap color for the link
     * @param  ?string  $badge  The text for the badge of the link
     * @param  string   $badgeColor  The Bootstrap background color of the badge
     * @param  ?string  $badgeClasses  A set of extra CSS classes for the badge
     * @return void
     */
    public function __construct(
        string $label,
        ?string $icon = null,
        string $url = '#',
        ?string $color = null,
        ?string $badge = null,
        string $badgeColor = 'secondary',
        ?string $badgeClasses = null
    ) {
        $this->label = html_entity_decode($label);
        $this->icon = $icon;
        $this->url = filter_var($url, FILTER_VALIDATE_URL) ? $url : '#';
        $this->badge = html_entity_decode($badge);
        $this->linkClasses = $this->getLinkClasses($color);

        // If the badge is not empty, set the CSS classes for the badge.
        // Otherwise, set them to null.

        $this->badgeClasses = ! empty($badge)
            ? $this->getBadgeClasses($badgeColor, $badgeClasses)
            : null;
    }

    /**
     * Gets the set of CSS classes for the link.
     *
     * @param  ?string  $color  The Bootstrap color for the link
     * @return string
     */
    protected function getLinkClasses(?string $color): string
    {
        $classes = ['nav-link', 'user-select-none'];

        if (! empty($color)) {
            $classes[] = "text-{$color}";
        }

        return implode(' ', $classes);
    }

    /**
     * Gets the set of CSS classes for the badge.
     *
     * @param  string   $color  The Bootstrap background color for the badge
     * @param  ?string  $extraClasses  A set of extra CSS classes for the badge
     * @return string
     */
    protected function getBadgeClasses(
        string $color,
        ?string $extraClasses
    ): string {
        $classes = ['nav-badge', 'badge', 'fw-bold', "bg-{$color}"];

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
        return view('ladmin::components.layout.sidebar.link');
    }
}
