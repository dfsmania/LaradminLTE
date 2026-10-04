<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Sidebar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Sidebar\Divider;
use Illuminate\View\View;

class DividerTest extends TestCase
{
    public function test_it_uses_the_default_color_when_none_is_given(): void
    {
        $divider = new Divider;

        $this->assertSame('text-body-tertiary', $divider->dividerClasses);
    }

    public function test_it_uses_the_given_color(): void
    {
        $divider = new Divider('warning');

        $this->assertSame('text-warning', $divider->dividerClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Divider)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.sidebar.divider', $view->getName());
    }
}
