<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Navbar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Navbar\DropdownMenu;
use Illuminate\View\View;

class DropdownMenuTest extends TestCase
{
    public function test_it_sets_defaults_for_the_dropdown(): void
    {
        $menu = new DropdownMenu;

        $this->assertSame('', $menu->label);
        $this->assertNull($menu->icon);

        $this->assertSame(
            'nav-link dropdown-toggle d-flex align-items-center',
            $menu->linkClasses
        );

        $this->assertSame('dropdown-menu', $menu->menuClasses);
    }

    public function test_it_decodes_the_label_and_adds_toggler_classes(): void
    {
        $menu = new DropdownMenu(
            label: 'Tools &amp; more',
            icon: 'bi bi-tools',
            color: 'primary',
            isActive: true
        );

        $this->assertSame('Tools & more', $menu->label);
        $this->assertSame('bi bi-tools', $menu->icon);
        $this->assertStringContainsString('text-primary', $menu->linkClasses);
        $this->assertStringContainsString('active', $menu->linkClasses);
    }

    public function test_it_adds_menu_color_and_custom_classes(): void
    {
        $menu = new DropdownMenu(
            menuColor: 'dark',
            menuClasses: ' extra '
        );

        $this->assertSame('dropdown-menu bg-dark extra', $menu->menuClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new DropdownMenu)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame(
            'ladmin::layout.navbar.dropdown-menu',
            $view->getName()
        );
    }
}
