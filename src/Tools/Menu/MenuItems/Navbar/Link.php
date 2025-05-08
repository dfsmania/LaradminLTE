<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Navbar;

use DFSmania\LaradminLte\Tools\Menu\MenuItems\Base\AbstractLeafMenuItem;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Traits\ResolvesMenuItemUrl;
use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\View\Component;

class Link extends AbstractLeafMenuItem
{
    use ResolvesMenuItemUrl;

    /**
     * Defines the validation rules for the menu item configuration. These
     * rules are used with the Laravel Validator to ensure the configuration
     * adheres to the expected schema.
     *
     * @var array<string, string|array>
     */
    protected static array $cfgValidationRules = [
        'badge' => 'sometimes|string',
        'badge_classes' => 'sometimes|string',
        'badge_color' => 'sometimes|string',
        'color' => 'sometimes|string',
        'icon' => 'sometimes|string',
        'label' => 'required_without:icon|string',
        'position' => 'sometimes|in:left,right',
        'route' => 'sometimes|array',
        'type' => 'required',
        'url' => 'required_without:route|string',
    ];

    /**
     * Creates a new instance of the blade component for the menu item.
     *
     * This method is responsible for creating the appropriate blade component
     * based on the provided configuration. It should return an instance of the
     * component that will be used to render the menu item.
     *
     * @param  array  $config  The configuration array of the menu item
     * @return Component
     */
    protected static function makeBladeComponent(array $config): Component
    {
        return new Layout\Navbar\Link(
            icon: $config['icon'] ?? null,
            label: $config['label'] ?? null,
            url: static::getUrlFromConfig($config),
            color: $config['color'] ?? null,
            badge: $config['badge'] ?? null,
            badgeColor: $config['badge_color'] ?? null,
            badgeClasses: $config['badge_classes'] ?? null,
        );
    }
}
