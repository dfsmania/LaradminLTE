<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Navbar;

use DFSmania\LaradminLte\Tools\Menu\ActiveStrategies\CallableActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\ActiveStrategies\UrlActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\Contracts\ActiveStrategy;
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
        'is_active' => 'sometimes',
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
     * @param  bool  $isActive  Whether the component should be marked as active
     * @return Component
     */
    protected static function makeBladeComponent(
        array $config,
        bool $isActive = false
    ): Component {
        return new Layout\Navbar\Link(
            icon: $config['icon'] ?? null,
            label: $config['label'] ?? null,
            url: static::getUrlFromConfig($config),
            color: $config['color'] ?? null,
            badge: $config['badge'] ?? null,
            badgeColor: $config['badge_color'] ?? null,
            badgeClasses: $config['badge_classes'] ?? null,
            isActive: $isActive,
        );
    }

    /**
     * Creates a new instance of the active strategy for the menu item.
     *
     * This method is responsible for creating the appropriate active strategy
     * based on the provided configuration. It should return an instance of the
     * active strategy that'll be used to determine if the menu item is active.
     *
     * @param  array  $config  The configuration array of the menu item
     * @return ?ActiveStrategy
     */
    protected static function makeActiveStrategy(array $config): ?ActiveStrategy
    {
        // If a callable is provided in the configuration, we will use it to
        // determine the active status of the menu item. The callable should
        // accept the menu item raw configuration as an argument and return
        // a boolean value indicating the active status.

        if (isset($config['is_active']) && is_callable($config['is_active'])) {
            return new CallableActiveStrategy($config['is_active'], $config);
        }

        // Otherwise, the active strategy for a link menu item will be
        // determined by inspecting the URL specified in the configuration.

        return new UrlActiveStrategy(static::getUrlFromConfig($config));
    }
}
