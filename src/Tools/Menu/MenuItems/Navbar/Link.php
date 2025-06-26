<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Navbar;

use DFSmania\LaradminLte\Tools\Menu\ActiveStrategies\CallableActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\ActiveStrategies\UrlActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\Contracts\ActiveStrategy;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Base\AbstractLeafMenuItem;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Traits\ResolvesItemLocalization;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Traits\ResolvesItemUrl;
use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\View\Component;

class Link extends AbstractLeafMenuItem
{
    use ResolvesItemLocalization, ResolvesItemUrl;

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
        'is_allowed' => 'sometimes',
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

        // Resolve translations for the label and the badge, if they are
        // provided in the configuration.

        if (! empty($config['label'])) {
            $config['label'] = static::getTranslation($config['label']);
        }

        if (! empty($config['badge'])) {
            $config['badge'] = static::getTranslation($config['badge']);
        }

        // Create the blade component for the link menu item.

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
        // If a callable or a custom ActiveStrategy is provided in the
        // configuration, we will use it to determine the active status of the
        // menu item.

        if (! empty($config['is_active'])) {
            // If an instance of ActiveStrategy is provided, we will use it
            // directly. This allows for custom active strategies to be used
            // in the configuration.

            if ($config['is_active'] instanceof ActiveStrategy) {
                return $config['is_active'];
            }

            // If a callable is provided, we will create a new instance of
            // the CallableActiveStrategy class. This allows for custom logic
            // to be used to determine the active status of the menu item.

            if (is_callable($config['is_active'])) {
                return new CallableActiveStrategy(
                    $config['is_active'],
                    $config
                );
            }
        }

        // Otherwise, by default, the active strategy for a link menu item will
        // be determined by comparing the URL specified in the configuration
        // with the current request URL.

        return new UrlActiveStrategy(static::getUrlFromConfig($config));
    }
}
