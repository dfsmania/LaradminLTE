<?php

namespace DFSmania\LaradminLte\Tests\Unit\Events;

use DFSmania\LaradminLte\Events\BuildingMenu;
use DFSmania\LaradminLte\Tests\TestCase;

class BuildingMenuTest extends TestCase
{
    public function test_it_keeps_a_reference_to_the_menu_items(): void
    {
        $menu = [
            ['text' => 'Dashboard'],
        ];

        $event = new BuildingMenu($menu);
        $event->menu[] = ['text' => 'Users'];

        $this->assertSame([
            ['text' => 'Dashboard'],
            ['text' => 'Users'],
        ], $menu);
    }
}
