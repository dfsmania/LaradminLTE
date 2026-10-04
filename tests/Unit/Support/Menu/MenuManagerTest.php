<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Menu;

use DFSmania\LaradminLte\Support\Menu\Enums\MenuItemType;
use DFSmania\LaradminLte\Support\Menu\MenuManager;
use DFSmania\LaradminLte\Tests\TestCase;

class MenuManagerTest extends TestCase
{
    public function test_manager_classifies_navbar_and_sidebar_items(): void
    {
        $manager = new MenuManager([
            'navbar' => [
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Left',
                    'url' => '/left',
                ],
                [
                    'type' => MenuItemType::LINK,
                    'label' => 'Right',
                    'url' => '/right',
                    'position' => 'right',
                ],
                ['type' => 'invalid'],
            ],
            'sidebar' => [
                ['type' => MenuItemType::HEADER, 'label' => 'Sidebar'],
                ['type' => 'invalid'],
            ],
        ]);

        $this->assertCount(1, $manager->getLeftNavbarItems());
        $this->assertCount(1, $manager->getRightNavbarItems());
        $this->assertCount(1, $manager->getSidebarItems());

        $this->assertCount(3, array_merge(
            $manager->getLeftNavbarItems(),
            $manager->getRightNavbarItems(),
            $manager->getSidebarItems()
        ));

        $this->assertCount(1, $manager->getAllItems()['navbar-left']);
        $this->assertCount(1, $manager->getAllItems()['navbar-right']);
        $this->assertCount(1, $manager->getAllItems()['sidebar']);
    }
}
