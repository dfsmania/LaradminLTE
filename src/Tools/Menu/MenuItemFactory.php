<?php

namespace DFSmania\LaradminLte\Tools\Menu;

use DFSmania\LaradminLte\Tools\Menu\MenuItem;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Link;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\TreeviewMenu;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Header;
use DFSmania\LaradminLte\Tools\Menu\MenuItemType;

class MenuItemFactory
{
    /**
     * A mapping of placement types to their corresponding callable creators
     * for menu items. The key represents the placement (e.g., 'navbar' or
     * 'sidebar'), and the value is a callable that generates the appropriate
     * menu item instance.
     *
     * This structure enables the creation of distinct menu items tailored to
     * specific placements. In fact, the blade component used to render a menu
     * item varies based on its placement, and this approach also allows
     * support for different menu item types across placements.
     *
     * @var array<string, callable>
     */
    protected static array $builders = [
        'navbar' => [self::class, 'createNavbarItem'],
        'sidebar' => [self::class, 'createSidebarItem'],
    ];

    /**
     * Create a new MenuItem instance from its raw configuration array. A null
     * value will be returned if the configuration is invalid.
     *
     * @param  array  $config  The raw configuration array of the menu item
     * @param  string  $place  The placement of the item (navbar or sidebar)
     * @return ?MenuItem
     */
    public static function createFromConfig(
        array $config,
        string $place
    ): ?MenuItem {

        // Check if the menu item configuration has a valid type.

        if (! self::hasValidType($config)) {
            return null;
        }

        // Check if the specified placement value is valid/recognized.

        if (! isset(self::$builders[$place])) {
            return null;
        }

        // Return the corresponding menu item instance based on its type and
        // placement.

        return self::$builders[$place]($config);
    }

    /**
     * Create a new MenuItem instance for the navbar placement from its raw
     * configuration array. A null value will be returned if the configuration
     * is invalid.
     *
     * @param  array  $config  The raw configuration array for the menu item
     * @return ?MenuItem
     */
    protected static function createNavbarItem(array $config): ?MenuItem
    {
        switch ($config['type']) {
            case MenuItemType::HEADER:
                return Header::createFromConfig($config, 'navbar');

            case MenuItemType::LINK:
                return Link::createFromConfig($config, 'navbar');

            default:
                return null;
        }
    }

    /**
     * Create a new MenuItem instance for the sidebar placement from its raw
     * configuration array. A null value will be returned if the configuration
     * is invalid.
     *
     * @param  array  $config  The raw configuration array for the menu item
     * @return ?MenuItem
     */
    protected static function createSidebarItem(array $config): ?MenuItem
    {
        switch ($config['type']) {
            case MenuItemType::HEADER:
                return Header::createFromConfig($config, 'sidebar');

            case MenuItemType::LINK:
                return Link::createFromConfig($config, 'sidebar');

            case MenuItemType::TREEVIEW_MENU:
                return TreeviewMenu::createFromConfig($config);

            default:
                return null;
        }
    }

    /**
     * Check if a menu item configuration has a valid type.
     *
     * @param  array  $config  The raw configuration array of the menu item
     * @return bool
     */
    protected static function hasValidType(array $config): bool
    {
        return ! empty($config['type'])
            && $config['type'] instanceof MenuItemType;
    }
}
