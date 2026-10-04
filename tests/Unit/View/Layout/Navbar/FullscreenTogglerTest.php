<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Navbar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Navbar\FullscreenToggler;
use Illuminate\View\View;

class FullscreenTogglerTest extends TestCase
{
    public function test_it_sets_icons_and_default_link_classes(): void
    {
        $toggler = new FullscreenToggler('collapse', 'expand');

        $this->assertSame('collapse', $toggler->iconCollapse);
        $this->assertSame('expand', $toggler->iconExpand);

        $this->assertSame(
            'nav-link d-flex align-items-center',
            $toggler->linkClasses
        );
    }

    public function test_it_adds_a_color_class(): void
    {
        $toggler = new FullscreenToggler('collapse', 'expand', 'info');

        $this->assertStringContainsString('link-info', $toggler->linkClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new FullscreenToggler('collapse', 'expand'))->render();

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame(
            'ladmin::layout.navbar.fullscreen-toggler',
            $view->getName()
        );
    }
}
