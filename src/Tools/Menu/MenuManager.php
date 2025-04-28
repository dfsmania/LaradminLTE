<?php

namespace DFSmania\LaradminLte\Tools\Menu;

use DFSmania\LaradminLte\Tools\Menu\MenuItem;

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

        $this->readNavbarMenuItems($menuCfg['navbar'] ?? []);

        // Read and validate the provided sidebar menu items.

        $this->readSidebarMenuItems($menuCfg['sidebar'] ?? []);
    }

    /**
     * Retrieve all the menu items that have been already classified.
     *
     * @return array<string, MenuItem[]>
     */
    public function getAllMenuItems(): array
    {
        return $this->items;
    }

    /**
     * Retrieve the set of menu items to be placed in the left section of the
     * top navigation bar.
     *
     * @return MenuItem[]
     */
    public function getNavbarLeftMenuItems(): array
    {
        return $this->items['navbar-left'];
    }

    /**
     * Retrieve the set of menu items to be placed in the right section of the
     * top navigation bar.
     *
     * @return MenuItem[]
     */
    public function getNavbarRightMenuItems(): array
    {
        return $this->items['navbar-right'];
    }

    /**
     * Retrieve the set of menu items to be placed in the sidebar menu.
     *
     * @return MenuItem[]
     */
    public function getSidebarMenuItems(): array
    {
        return $this->items['sidebar'];
    }

    /**
     * Read, validate and classify the provided navbar menu items into their
     * corresponding placement categories. Invalid menu items in the array will
     * be skipped.
     *
     * @param  array  $items  An array with the raw menu items configuration
     * @return void
     */
    protected function readNavbarMenuItems(array $items): void
    {
        foreach ($items as $item) {
            // Create a menu item instance from the configuration. The menu
            // item instance will be null if the configuration is invalid.

            $menuItem = MenuItem::createFromConfig($item, 'navbar');

            // Check if the menu item is valid. If not, skip it.

            if ($menuItem === null) {
                continue;
            }

            // Check the position of the menu item relative to the navbar. It
            // should be either "left" or "right". If not defined, we will
            // assume a "left" position by default.

            if (isset($item['position']) && $item['position'] === 'right') {
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
        foreach ($items as $item) {
            // Create a menu item instance from the configuration. The menu
            // item instance will be null if the configuration is invalid.

            $menuItem = MenuItem::createFromConfig($item, 'sidebar');

            // Check if the menu item is valid. If not, skip it.

            if ($menuItem === null) {
                continue;
            }

            // Push the item into the sidebar menu.

            $this->items['sidebar'][] = $menuItem;
        }
    }
}
