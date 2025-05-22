<?php

namespace DFSmania\LaradminLte\Tools\Menu\MenuItems\Sidebar;

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
        'badge' => 'sometimes|string',
        'badge_classes' => 'sometimes|string',
        'badge_color' => 'sometimes|string',
        'color' => 'sometimes|string',
        'icon' => 'sometimes|string',
        'is_allowed' => 'sometimes',
        'label' => 'required|string',
        'submenu' => 'required|array',
        'toggler_icon' => 'sometimes|string',
        'type' => 'required',
    ];

    /**
     * Defines the set of allowed child types for this menu item. This is used
     * to determine which types of menu items can be nested under this item.
     *
     * @var MenuItemType[]
     */
    protected static array $allowedChildTypes = [
        MenuItemType::LINK,
        MenuItemType::MENU,
    ];

    /**
     * Specifies where the child items will be rendered within the admin panel
     * layout. This is required because the building process of a menu item
     * may be different depending on its placement.
     *
     * @var MenuPlacement
     */
    protected static MenuPlacement $childrenPlacement = MenuPlacement::SIDEBAR;

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

        // Setup the toggler icon for the menu item. Fallback to the default
        // icon if no other is provided.

        $togglerIcon = $config['toggler_icon']
            ?? config('ladmin.icons.treeview_toggler');

        // Create and return the blade component for the menu item.

        return new Layout\Sidebar\TreeviewMenu(
            label: $config['label'],
            icon: $config['icon'] ?? null,
            color: $config['color'] ?? null,
            badge: $config['badge'] ?? null,
            badgeColor: $config['badge_color'] ?? null,
            badgeClasses: $config['badge_classes'] ?? null,
            togglerIcon: $togglerIcon,
            isActive: $isActive,
        );
    }
}
