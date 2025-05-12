<?php

namespace DFSmania\LaradminLte\Tools\Menu;

use DFSmania\LaradminLte\Tools\Menu\Contracts\MenuItem;
use DFSmania\LaradminLte\Tools\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement;

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
     * varies based on its placement. This approach also allows support
     * for different menu item types across placements.
     *
     * @var array<string, array<string, callable>>
     */
    protected static array $builders = [

        // The set of menu item builders allowed for the navbar.
        MenuPlacement::NAVBAR->value => [
            MenuItemType::DIVIDER->value => [
                MenuItems\Navbar\Divider::class,
                'createFromConfig',
            ],
            MenuItemType::FULLSCREEN_TOGGLER->value => [
                MenuItems\Navbar\FullscreenToggler::class,
                'createFromConfig',
            ],
            MenuItemType::HEADER->value => [
                MenuItems\Navbar\Header::class,
                'createFromConfig',
            ],
            MenuItemType::LINK->value => [
                MenuItems\Navbar\Link::class,
                'createFromConfig',
            ],
            MenuItemType::MENU->value => [
                MenuItems\Navbar\Menu::class,
                'createFromConfig',
            ],
        ],

        // The set of menu item builders allowed for the sidebar.
        MenuPlacement::SIDEBAR->value => [
            MenuItemType::DIVIDER->value => [
                MenuItems\Sidebar\Divider::class,
                'createFromConfig',
            ],
            MenuItemType::HEADER->value => [
                MenuItems\Sidebar\Header::class,
                'createFromConfig',
            ],
            MenuItemType::LINK->value => [
                MenuItems\Sidebar\Link::class,
                'createFromConfig',
            ],
            MenuItemType::MENU->value => [
                MenuItems\Sidebar\Menu::class,
                'createFromConfig',
            ],
        ],

        // The set of menu item builders allowed for the navbar dropdown.
        // TODO: Support for nested submenus may be added in the future.
        // This feature would require foundational support from the AdminLTE
        // package or Bootstrap 5, as it is not currently supported.
        MenuPlacement::NAVBAR_DROPDOWN->value => [
            MenuItemType::DIVIDER->value => [
                MenuItems\Navbar\DropdownDivider::class,
                'createFromConfig',
            ],
            MenuItemType::HEADER->value => [
                MenuItems\Navbar\DropdownHeader::class,
                'createFromConfig',
            ],
            MenuItemType::LINK->value => [
                MenuItems\Navbar\DropdownLink::class,
                'createFromConfig',
            ],
        ],
    ];

    /**
     * Create a new MenuItem instance from its raw configuration array. A null
     * value will be returned if the configuration is invalid.
     *
     * @param  array  $config  The raw configuration array of the menu item
     * @param  MenuPlacement  $place  The placement of the item
     * @return ?MenuItem
     */
    public static function createFromConfig(
        array $config,
        MenuPlacement $place
    ): ?MenuItem {

        // Check if the menu item configuration has a valid type.

        if (! self::hasValidType($config)) {
            return null;
        }

        // Retrieve the builder function for the specified placement and menu
        // item type. If no builder is found, return null to indicate the menu
        // item is unsupported.

        $builder = self::getBuilderFor($place, $config['type']);

        if (! $builder) {
            return null;
        }

        // Attempt to create the menu item using the appropriate builder
        // function. If the creation fails, we will return null to indicate
        // that the menu item is not valid.

        return $builder($config);
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

    /**
     * Get the builder function for a specific placement and menu item type.
     * It will return null if no builder is found for the specified placement
     * and type.
     *
     * @param  MenuPlacement  $place  The placement of the item
     * @param  MenuItemType  $type  The type of the menu item
     * @return ?callable
     */
    protected static function getBuilderFor(
        MenuPlacement $place,
        MenuItemType $type
    ): ?callable {
        return self::$builders[$place->value][$type->value] ?? null;
    }
}
