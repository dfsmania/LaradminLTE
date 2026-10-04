<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Sidebar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Sidebar\Link;
use Illuminate\View\View;

class LinkTest extends TestCase
{
    public function test_it_sets_link_data_and_default_classes(): void
    {
        $link = new Link('Docs &amp; help', 'bi bi-book');

        $this->assertSame('Docs & help', $link->label);
        $this->assertSame('bi bi-book', $link->icon);
        $this->assertSame('#', $link->url);
        $this->assertSame('nav-link align-items-center', $link->linkClasses);
        $this->assertNull($link->badgeClasses);
    }

    public function test_it_rejects_non_absolute_urls(): void
    {
        $link = new Link('Dashboard', url: '/dashboard');

        $this->assertSame('#', $link->url);
    }

    public function test_it_adds_color_and_active_classes(): void
    {
        $link = new Link('Dashboard', color: 'primary', isActive: true);

        $this->assertStringContainsString('text-primary', $link->linkClasses);
        $this->assertStringContainsString('active', $link->linkClasses);
    }

    public function test_it_decodes_badges_and_uses_default_badge_color(): void
    {
        $link = new Link('Messages', badge: '4 &amp; new');

        $this->assertSame('4 & new', $link->badge);
        $this->assertSame(
            'nav-badge badge fw-bold bg-secondary',
            $link->badgeClasses
        );
    }

    public function test_it_uses_custom_badge_classes_and_color(): void
    {
        $link = new Link(
            'Messages',
            badge: 'New',
            badgeColor: 'info',
            badgeClasses: ' extra '
        );

        $this->assertStringContainsString('bg-info', $link->badgeClasses);
        $this->assertStringContainsString('extra', $link->badgeClasses);
    }

    public function test_it_uses_livewire_navigation_when_enabled(): void
    {
        config(['ladmin.main.livewire.spa_navigation' => true]);

        $link = new Link('Docs', url: 'https://example.test/docs');
        $defaultLink = new Link('Home');

        $this->assertTrue($link->isLivewireNavigate());
        $this->assertFalse($defaultLink->isLivewireNavigate());
    }

    public function test_it_disables_livewire_navigation_if_not_enabled(): void
    {
        config(['ladmin.main.livewire.spa_navigation' => false]);

        $link = new Link('Docs', url: 'https://example.test/docs');

        $this->assertFalse($link->isLivewireNavigate());
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Link('Dashboard'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.sidebar.link', $view->getName());
    }
}
