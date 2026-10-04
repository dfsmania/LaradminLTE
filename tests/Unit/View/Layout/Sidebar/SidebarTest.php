<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Sidebar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Sidebar\Sidebar;
use Illuminate\View\View;

class SidebarTest extends TestCase
{
    public function test_it_uses_default_classes_for_sidebar_and_brand(): void
    {
        $sidebar = new Sidebar;

        $cfgBrandTextClasses = implode(
            ' ',
            array_filter(config('ladmin.main.logo.text_classes', []))
        );

        $cfgBrandImageClasses = implode(
            ' ',
            array_filter(config('ladmin.main.logo.image_classes', []))
        );

        $this->assertStringContainsString(
            'app-sidebar',
            $sidebar->sidebarClasses
        );

        $this->assertStringContainsString(
            'bg-body-secondary',
            $sidebar->sidebarClasses
        );

        $this->assertSame('dark', $sidebar->bootstrapTheme);
        $this->assertSame($cfgBrandTextClasses, $sidebar->brandTextClasses);
        $this->assertSame($cfgBrandImageClasses, $sidebar->brandImageClasses);
    }

    public function test_it_uses_configured_sidebar_classes_and_theme(): void
    {
        config([
            'ladmin.main.sidebar.classes' => ['custom-sidebar', ''],
            'ladmin.main.sidebar.bootstrap_theme' => 'light',
            'ladmin.main.logo.text_classes' => ['fw-bold', ''],
            'ladmin.main.logo.image_classes' => ['rounded'],
        ]);

        $sidebar = new Sidebar;

        $this->assertStringContainsString(
            'custom-sidebar',
            $sidebar->sidebarClasses
        );

        $this->assertSame('light', $sidebar->bootstrapTheme);
        $this->assertSame('fw-bold', $sidebar->brandTextClasses);
        $this->assertSame('rounded', $sidebar->brandImageClasses);
    }

    public function test_it_ignores_invalid_class_config_and_theme(): void
    {
        config([
            'ladmin.main.sidebar.classes' => 'invalid',
            'ladmin.main.sidebar.bootstrap_theme' => 'invalid',
            'ladmin.main.logo.text_classes' => 'invalid',
            'ladmin.main.logo.image_classes' => 'invalid',
        ]);

        $sidebar = new Sidebar;

        $this->assertSame('app-sidebar', $sidebar->sidebarClasses);
        $this->assertSame('', $sidebar->bootstrapTheme);
        $this->assertSame('', $sidebar->brandTextClasses);
        $this->assertSame('', $sidebar->brandImageClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Sidebar)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.sidebar.sidebar', $view->getName());
    }
}
