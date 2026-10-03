<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Footer;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Footer\Footer;
use Illuminate\View\View;

class FooterTest extends TestCase
{
    public function test_it_merges_the_default_configured_classes(): void
    {
        $footer = new Footer;

        $this->assertStringContainsString('app-footer', $footer->footerClasses);
        $this->assertStringContainsString('bg-body', $footer->footerClasses);
    }

    public function test_it_merges_custom_configured_classes(): void
    {
        config(['ladmin.main.footer.classes' => ['custom-footer', '']]);

        $footer = new Footer;

        $this->assertSame('app-footer custom-footer', $footer->footerClasses);
    }

    public function test_it_ignores_non_array_configured_classes(): void
    {
        config(['ladmin.main.footer.classes' => 'not-an-array']);

        $footer = new Footer;

        $this->assertSame('app-footer', $footer->footerClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Footer)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.footer.footer', $view->getName());
    }
}
