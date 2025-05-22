<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Navbar;

use DFSmania\LaradminLte\Tools\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement;
use DFSmania\LaradminLte\Tools\Menu\MenuItems\Base\AbstractCompositeMenuItem;
use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\View\Component;

class Menu extends AbstractCompositeMenuItem
{
    /**
     * Defines the validation rules for the menu item configuration. These
     * rules are used with the Laravel Validator to ensure the configuration
     * adheres to the expected schema.
     *
     * @var array<string, string|array>
     */
    protected static array $cfgValidationRules = [
        'color' => 'sometimes|string',
        'icon' => 'sometimes|string',
        'is_allowed' => 'sometimes',
        'menu_color' => 'sometimes|string',
        'label' => 'required_without:icon|string',
        'position' => 'sometimes|in:left,right',
        'submenu' => 'required|array',
        'type' => 'required',
    ];

    /**
     * Defines the set of allowed child types for this menu item. This is used
     * to determine which types of menu items can be nested under this item.
     *
     * @var MenuItemType[]
     */
    protected static array $allowedChildTypes = [
        MenuItemType::DIVIDER,
        MenuItemType::HEADER,
        MenuItemType::LINK,
    ];

    /**
     * Specifies where the child items will be rendered within the admin panel
     * layout. This is required because the building process of a menu item
     * may be different depending on its placement.
     *
     * @var MenuPlacement
     */
    protected static MenuPlacement $childrenPlacement =
        MenuPlacement::NAVBAR_DROPDOWN;

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

        // Setup the dropdown menu classes.

        $menuClasses = ($config['position'] ?? 'left') === 'right'
            ? 'dropdown-menu-end'
            : 'dropdown-menu-start';

        // Create and return the blade component for the menu item.

        return new Layout\Navbar\DropdownMenu(
            label: $config['label'] ?? null,
            icon: $config['icon'] ?? null,
            color: $config['color'] ?? null,
            menuColor: $config['menu_color'] ?? null,
            menuClasses: $menuClasses,
            isActive: $isActive,
        );
    }
}
