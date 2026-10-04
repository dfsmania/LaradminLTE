<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Sidebar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Sidebar\TreeviewMenu;
use Illuminate\View\View;

class TreeviewMenuTest extends TestCase
{
    public function test_it_sets_default_menu_values(): void
    {
        $menu = new TreeviewMenu('Settings');

        $this->assertSame('Settings', $menu->label);
        $this->assertSame('nav-item', $menu->navItemClasses);
        $this->assertSame('nav-link align-items-center', $menu->linkClasses);
        $this->assertNull($menu->badgeClasses);
        $this->assertNull($menu->togglerIcon);
    }

    public function test_it_decodes_the_label_and_adds_active_classes(): void
    {
        $menu = new TreeviewMenu(
            'Tools &amp; settings',
            color: 'primary',
            togglerIcon: 'bi bi-chevron-down',
            isActive: true
        );

        $this->assertSame('Tools & settings', $menu->label);
        $this->assertSame('nav-item menu-open', $menu->navItemClasses);
        $this->assertSame('bi bi-chevron-down', $menu->togglerIcon);

        $this->assertSame(
            'nav-link align-items-center text-primary active',
            $menu->linkClasses
        );
    }

    public function test_it_builds_default_badge_classes(): void
    {
        $defaultBadge = new TreeviewMenu('Inbox', badge: '5');

        $this->assertSame(
            'nav-badge badge fw-bold me-3 bg-secondary',
            $defaultBadge->badgeClasses
        );
    }

    public function test_it_builds_badge_classes_with_customizations(): void
    {
        $customBadge = new TreeviewMenu(
            'Inbox',
            badge: 'New',
            badgeColor: 'success',
            badgeClasses: ' extra '
        );

        $this->assertSame(
            'nav-badge badge fw-bold me-3 bg-success extra',
            $customBadge->badgeClasses
        );
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new TreeviewMenu('Settings'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame(
            'ladmin::layout.sidebar.treeview-menu',
            $view->getName()
        );
    }
}
