<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Scripts;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Scripts\OverlayScrollbarsInit;
use Illuminate\View\View;

class OverlayScrollbarsInitTest extends TestCase
{
    public function test_it_uses_the_dark_theme_for_a_light_sidebar(): void
    {
        config(['ladmin.main.sidebar.bootstrap_theme' => 'light']);

        $scripts = new OverlayScrollbarsInit;

        $this->assertSame('os-theme-dark', $scripts->theme);
    }

    public function test_it_uses_the_light_theme_for_a_dark_sidebar(): void
    {
        config(['ladmin.main.sidebar.bootstrap_theme' => 'dark']);

        $scripts = new OverlayScrollbarsInit;

        $this->assertSame('os-theme-light', $scripts->theme);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new OverlayScrollbarsInit)->render();

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame(
            'ladmin::layout.scripts.overlay-scrollbars-init',
            $view->getName()
        );
    }
}
