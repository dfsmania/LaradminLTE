<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Sidebar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Sidebar\Header;
use Illuminate\View\View;

class HeaderTest extends TestCase
{
    public function test_it_sets_the_label_icon_and_default_classes(): void
    {
        $header = new Header('Admin &amp; tools', 'bi bi-gear');

        $this->assertSame('Admin & tools', $header->label);
        $this->assertSame('bi bi-gear', $header->icon);
        $this->assertSame('nav-header', $header->headerClasses);
    }

    public function test_it_adds_a_text_color_class(): void
    {
        $header = new Header('Admin', color: 'muted');

        $this->assertSame('nav-header text-muted', $header->headerClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Header('Admin'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.sidebar.header', $view->getName());
    }
}
