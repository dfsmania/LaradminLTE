<?php

namespace DFSmania\LaradminLte\Tests\Unit\Events;

use DFSmania\LaradminLte\Events\BuildingMenu;
use DFSmania\LaradminLte\Support\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Tests\TestCase;

class BuildingMenuTest extends TestCase
{
    public function test_it_keeps_a_reference_to_the_menu_items(): void
    {
        // Initial menu structure before the event is created.

        $menu = [
            'sidebar' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Dashboard',
                    'url' => '/dashboard',
                ],
            ],
        ];

        // Create the event with the initial menu structure and add a new menu
        // item.

        $event = new BuildingMenu($menu);
        $event->menu['sidebar'][] = [
            'type' => MenuItemType::LINK,
            'label' => 'Users',
            'url' => '/users',
        ];

        // Assert that the original menu array has been updated with the new
        // item.

        $this->assertSame([
            'sidebar' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Dashboard',
                    'url' => '/dashboard',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Users',
                    'url' => '/users',
                ],
            ],
        ], $menu);
    }
}
