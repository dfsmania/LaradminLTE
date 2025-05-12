<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\View\View;

class DropdownLink extends Component
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
     * The icon associated with the link (optional).
     *
     * @var ?string
     */
    public ?string $icon;

    /**
     * The label of the link (optional).
     *
     * @var ?string
     */
    public ?string $label;

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
     * @param  ?string  $icon  The icon associated with the link
     * @param  ?string  $label  The label of the link
     * @param  ?string  $url  The URL (href attribute) of the link
     * @param  ?string  $color  The Bootstrap color of the link
     * @param  ?string  $badge  The text for the badge of the link
     * @param  ?string  $badgeColor  The Bootstrap background color of the badge
     * @param  ?string  $badgeClasses  A set of extra CSS classes for the badge
     * @return void
     */
    public function __construct(
        ?string $icon = null,
        ?string $label = null,
        ?string $url = null,
        ?string $color = null,
        ?string $badge = null,
        ?string $badgeColor = null,
        ?string $badgeClasses = null
    ) {
        $this->icon = $icon;
        $this->label = html_entity_decode($label);
        $this->url = filter_var($url, FILTER_VALIDATE_URL) ? $url : '#';
        $this->badge = html_entity_decode($badge);
        $this->linkClasses = $this->getLinkClasses($color);

        // If the badge is not empty, set the CSS classes for the badge.
        // Otherwise, set them to null. The default color for the badge is
        // 'secondary' if not provided.

        $badgeColor = $badgeColor ?? 'secondary';

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
        $classes = ['dropdown-item', 'd-flex', 'align-items-center'];

        if (! empty($color)) {
            $classes[] = "link-{$color}";
        }

        return implode(' ', $classes);
    }

    /**
     * Gets the set of CSS classes for the badge.
     *
     * @param  string  $color  The Bootstrap background color for the badge
     * @param  ?string  $extraClasses  A set of extra CSS classes for the badge
     * @return string
     */
    protected function getBadgeClasses(
        string $color,
        ?string $extraClasses
    ): string {
        $classes = ['badge', 'float-end', 'ms-2', 'fw-bold', "bg-{$color}"];

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
        return view('ladmin::components.layout.navbar.dropdown-link');
    }
}
