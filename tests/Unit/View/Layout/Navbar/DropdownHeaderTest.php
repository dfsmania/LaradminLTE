<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Navbar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Navbar\DropdownHeader;
use Illuminate\View\View;

class DropdownHeaderTest extends TestCase
{
    public function test_it_sets_the_label_icon_and_default_classes(): void
    {
        $header = new DropdownHeader('Recent &amp; saved', 'bi bi-clock');

        $this->assertSame('Recent & saved', $header->label);
        $this->assertSame('bi bi-clock', $header->icon);
        $this->assertSame(
            'dropdown-header d-flex align-items-center',
            $header->headerClasses
        );
    }

    public function test_it_adds_a_text_color_class(): void
    {
        $header = new DropdownHeader('Recent', color: 'info');

        $this->assertStringContainsString('text-info', $header->headerClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new DropdownHeader('Recent'))->render();

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame(
            'ladmin::layout.navbar.dropdown-header',
            $view->getName()
        );
    }
}
