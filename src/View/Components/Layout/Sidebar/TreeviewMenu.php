<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class TreeviewMenu extends Component
{
    /**
     * The text for the badge of the treeview menu (optional).
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
     * The icon associated with the treeview menu (optional).
     *
     * @var ?string
     */
    public ?string $icon;

    /**
     * The label of the treeview menu.
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
     * The icon of the treeview menu toggler.
     *
     * @var string
     */
    public ?string $togglerIcon;

    /**
     * Create a new component instance.
     *
     * @param  string  $label  The label of the treeview menu
     * @param  ?string  $icon  The icon associated with the treeview menu
     * @param  ?string  $color  The Bootstrap color for the treeview menu
     * @param  ?string  $badge  The text for the badge of the treeview menu
     * @param  ?string  $badgeColor  The Bootstrap background color of the badge
     * @param  ?string  $badgeClasses  A set of extra CSS classes for the badge
     * @param  ?string  $togglerIcon  The icon of the menu toggler
     * @param  bool  $isActive  Whether the menu should be marked as active
     * @return void
     */
    public function __construct(
        string $label,
        ?string $icon = null,
        ?string $color = null,
        ?string $badge = null,
        ?string $badgeColor = null,
        ?string $badgeClasses = null,
        ?string $togglerIcon = null,
        bool $isActive = false
    ) {
        $this->label = html_entity_decode($label);
        $this->icon = $icon;
        $this->badge = html_entity_decode($badge);
        $this->togglerIcon = $togglerIcon;
        $this->linkClasses = $this->getLinkClasses($color, $isActive);

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
     * @param  bool  $isActive  Whether the link should be marked as active
     * @return string
     */
    protected function getLinkClasses(?string $color, bool $isActive): string
    {
        $classes = ['nav-link', 'align-items-center'];

        if (! empty($color)) {
            $classes[] = "text-{$color}";
        }

        if ($isActive) {
            $classes[] = 'active';
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
        $classes = ['nav-badge', 'badge', 'fw-bold', 'me-3', "bg-{$color}"];

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
        return view('ladmin::components.layout.sidebar.treeview-menu');
    }
}
