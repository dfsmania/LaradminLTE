<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\MainContent;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\MainContent\MainContent;
use Illuminate\View\View;

class MainContentTest extends TestCase
{
    public function test_it_merges_the_default_configured_classes(): void
    {
        $content = new MainContent;

        $this->assertStringContainsString(
            'app-main',
            $content->mainContentClasses
        );

        $this->assertStringContainsString(
            'bg-body-tertiary',
            $content->mainContentClasses
        );
    }

    public function test_it_merges_custom_configured_classes(): void
    {
        config(['ladmin.main.main_content.classes' => ['custom-main', '']]);

        $content = new MainContent;

        $this->assertSame('app-main custom-main', $content->mainContentClasses);
    }

    public function test_it_ignores_non_array_configured_classes(): void
    {
        config(['ladmin.main.main_content.classes' => 'not-an-array']);

        $content = new MainContent;

        $this->assertSame('app-main', $content->mainContentClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new MainContent)->render();

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame(
            'ladmin::layout.main_content.main-content',
            $view->getName()
        );
    }
}
