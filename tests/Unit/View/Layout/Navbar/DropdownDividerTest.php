<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Navbar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Navbar\DropdownDivider;
use Illuminate\View\View;

class DropdownDividerTest extends TestCase
{
    public function test_it_uses_the_base_class_without_a_color(): void
    {
        $divider = new DropdownDivider;

        $this->assertSame('dropdown-divider', $divider->dividerClasses);
    }

    public function test_it_adds_a_background_color_class(): void
    {
        $divider = new DropdownDivider('light');

        $this->assertSame(
            'dropdown-divider bg-light',
            $divider->dividerClasses
        );
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new DropdownDivider)->render();

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame(
            'ladmin::layout.navbar.dropdown-divider',
            $view->getName()
        );
    }
}
