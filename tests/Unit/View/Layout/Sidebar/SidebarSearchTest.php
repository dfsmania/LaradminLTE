<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Sidebar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Sidebar\SidebarSearch;
use Illuminate\View\View;

class SidebarSearchTest extends TestCase
{
    public function test_it_uses_the_default_search_target(): void
    {
        $search = new SidebarSearch;

        $this->assertSame('ul.sidebar-menu', $search->target);
    }

    public function test_it_uses_a_custom_search_target(): void
    {
        $search = new SidebarSearch('#navigation');

        $this->assertSame('#navigation', $search->target);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new SidebarSearch)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame(
            'ladmin::layout.sidebar.sidebar-search',
            $view->getName()
        );
    }
}
