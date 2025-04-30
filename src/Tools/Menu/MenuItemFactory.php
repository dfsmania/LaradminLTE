<?php

namespace DFSmania\LaradminLte\Tools\Menu;

use DFSmania\LaradminLte\Tools\Menu\MenuItem;
use DFSmania\LaradminLte\Tools\Menu\MenuItemType;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Header;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Link;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Menu;

class MenuItemFactory
{
    /**
     * A mapping of placement types to their corresponding callable creators
     * for menu items. The key represents the placement (e.g., 'navbar' or
     * 'sidebar'), and the value is an array of menu item builders allowed for
     * that placement.
     *
     * This structure enables the creation of distinct menu items tailored to
     * specific placements. The blade component used to render a menu item
     * varies based on its placement, and this approach also allows support
     * for different menu item types across placements.
     *
     * @var array<string, array<string, callable>>
     */
    protected static array $builders = [

        // The set of menu item builders allowed for the navbar.
        // TODO: Add support for dropdown menus in the navbar.
        'navbar' => [
            MenuItemType::HEADER->value => [Header::class, 'createFromConfig'],
            MenuItemType::LINK->value => [Link::class, 'createFromConfig'],
        ],

        // The set of menu item builders allowed for the sidebar.
        'sidebar' => [
            MenuItemType::HEADER->value => [Header::class, 'createFromConfig'],
            MenuItemType::LINK->value => [Link::class, 'createFromConfig'],
            MenuItemType::MENU->value => [Menu::class, 'createFromConfig'],
        ],
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

        // Check if the specified placement value is valid or recognized.

        if (! isset(self::$builders[$place])) {
            return null;
        }

        // Check if the menu item type is valid for the specified placement.

        $itemType = $config['type']->value;

        if (! isset(self::$builders[$place][$itemType])) {
            return null;
        }

        // Attempt to create the menu item using the appropriate builder
        // function. If the creation fails, we will return null to indicate
        // that the menu item is not valid.

        return self::$builders[$place][$itemType]($config, $place);
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
