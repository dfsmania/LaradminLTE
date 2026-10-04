<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Navbar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Navbar\Header;
use Illuminate\View\View;

class HeaderTest extends TestCase
{
    public function test_it_sets_the_label_icon_and_default_classes(): void
    {
        $header = new Header('News &amp; updates', 'bi bi-star');

        $this->assertSame('News & updates', $header->label);
        $this->assertSame('bi bi-star', $header->icon);

        $this->assertSame(
            'nav-item nav-link pe-none d-flex align-items-center',
            $header->headerClasses
        );
    }

    public function test_it_adds_a_text_color_class(): void
    {
        $header = new Header('News', color: 'primary');

        $this->assertStringContainsString(
            'text-primary',
            $header->headerClasses
        );
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Header('News'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.navbar.header', $view->getName());
    }
}
