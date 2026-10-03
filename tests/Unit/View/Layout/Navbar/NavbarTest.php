<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Navbar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Navbar\Navbar;
use Illuminate\View\View;

class NavbarTest extends TestCase
{
    public function test_it_merges_default_configured_classes(): void
    {
        $navbar = new Navbar;

        $this->assertSame(
            'app-header navbar navbar-expand bg-body',
            $navbar->navbarClasses
        );
    }

    public function test_it_merges_custom_configured_classes(): void
    {
        config(['ladmin.main.navbar.classes' => ['custom-navbar', '']]);

        $navbar = new Navbar;

        $this->assertStringContainsString(
            'custom-navbar',
            $navbar->navbarClasses
        );
    }

    public function test_it_ignores_non_array_configured_classes(): void
    {
        config(['ladmin.main.navbar.classes' => 'invalid']);

        $navbar = new Navbar;

        $this->assertSame(
            'app-header navbar navbar-expand',
            $navbar->navbarClasses
        );
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Navbar)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.navbar.navbar', $view->getName());
    }
}
