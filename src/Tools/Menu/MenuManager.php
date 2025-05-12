<?php

namespace DFSmania\LaradminLte\Tools\Menu;

use DFSmania\LaradminLte\Tools\Menu\Contracts\MenuItem;
use DFSmania\LaradminLte\Tools\Menu\Enums\MenuPlacement;

class MenuManager
{
    /**
     * An array of menu items to be included in the Admin panel, categorized
     * into the following sections:
     *
     * - 'navbar-left': Items for the left section of the top navigation bar.
     * - 'navbar-right': Items for the right section of the top navigation bar.
     * - 'sidebar': Items for the sidebar menu.
     *
     * @var array<string, MenuItem[]>
     */
    protected array $items = [
        'navbar-left' => [],
        'navbar-right' => [],
        'sidebar' => [],
    ];

    /**
     * Create a new instance of the class.
     *
     * @param  array  $menuCfg  An array with the raw menu items configuration
     * @return void
     */
    public function __construct(array $menuCfg = [])
    {
        // Read, validate and classify the provided navbar menu items.

        $items = $menuCfg[MenuPlacement::NAVBAR->value] ?? [];
        $this->readNavbarMenuItems($items);

        // Read and validate the provided sidebar menu items.

        $items = $menuCfg[MenuPlacement::SIDEBAR->value] ?? [];
        $this->readSidebarMenuItems($items);
    }

    /**
     * Retrieve all the menu items that have been already classified.
     *
     * @return array<string, MenuItem[]>
     */
    public function getAllItems(): array
    {
        return $this->items;
    }

    /**
     * Retrieve the set of menu items to be placed in the left section of the
     * top navigation bar.
     *
     * @return MenuItem[]
     */
    public function getLeftNavbarItems(): array
    {
        return $this->items['navbar-left'];
    }

    /**
     * Retrieve the set of menu items to be placed in the right section of the
     * top navigation bar.
     *
     * @return MenuItem[]
     */
    public function getRightNavbarItems(): array
    {
        return $this->items['navbar-right'];
    }

    /**
     * Retrieve the set of menu items to be placed in the sidebar menu.
     *
     * @return MenuItem[]
     */
    public function getSidebarItems(): array
    {
        return $this->items['sidebar'];
    }

    /**
     * Read, validate and classify the provided navbar menu items into their
     * respective placement categories. Invalid menu items in the array will
     * be skipped.
     *
     * @param  array  $items  An array with the raw menu items configuration
     * @return void
     */
    protected function readNavbarMenuItems(array $items): void
    {
        foreach ($items as $itemCfg) {
            // Attempt to create a new menu item instance from the provided
            // configuration. If the configuration is invalid, the resulting
            // menu item instance will be null, and the item will be skipped.

            $place = MenuPlacement::NAVBAR;
            $menuItem = MenuItemFactory::createFromConfig($itemCfg, $place);

            if ($menuItem === null) {
                continue;
            }

            // Determine the position of the menu item within the navbar. Valid
            // positions are "left" or "right". Defaults to "left" if not
            // specified.

            if (($itemCfg['position'] ?? 'left') === 'right') {
                $this->items['navbar-right'][] = $menuItem;
            } else {
                $this->items['navbar-left'][] = $menuItem;
            }
        }
    }

    /**
     * Read and validate the provided sidebar menu items. Invalid menu items in
     * the array will be skipped.
     *
     * @param  array  $items  An array with the raw menu items configuration
     * @return void
     */
    protected function readSidebarMenuItems(array $items): void
    {
        foreach ($items as $itemCfg) {
            // Attempt to create a new menu item instance from the provided
            // configuration. If the configuration is invalid, the resulting
            // menu item instance will be null, and the item will be skipped.

            $place = MenuPlacement::SIDEBAR;
            $menuItem = MenuItemFactory::createFromConfig($itemCfg, $place);

            if ($menuItem === null) {
                continue;
            }

            // Push the menu item into the sidebar menu.

            $this->items['sidebar'][] = $menuItem;
        }
    }
}
