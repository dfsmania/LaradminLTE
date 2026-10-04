<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Navbar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Navbar\DropdownLink;
use Illuminate\View\View;

class DropdownLinkTest extends TestCase
{
    public function test_it_sets_default_link_data_and_classes(): void
    {
        $link = new DropdownLink(label: 'Help &amp; support');

        $this->assertSame('Help & support', $link->label);
        $this->assertSame('#', $link->url);

        $this->assertSame(
            'dropdown-item d-flex align-items-center',
            $link->linkClasses
        );

        $this->assertNull($link->badgeClasses);
    }

    public function test_it_rejects_non_absolute_urls(): void
    {
        $link = new DropdownLink(url: '/help');

        $this->assertSame('#', $link->url);
    }

    public function test_it_adds_color_and_active_classes(): void
    {
        $link = new DropdownLink(color: 'success', isActive: true);

        $this->assertStringContainsString('link-success', $link->linkClasses);
        $this->assertStringContainsString('active', $link->linkClasses);
    }

    public function test_it_decodes_badges_and_uses_default_badge_color(): void
    {
        $link = new DropdownLink(badge: '2 &amp; more');

        $this->assertSame('2 & more', $link->badge);

        $this->assertSame(
            'badge float-end ms-2 fw-bold bg-secondary',
            $link->badgeClasses
        );
    }

    public function test_it_uses_custom_badge_classes_and_color(): void
    {
        $link = new DropdownLink(
            badge: 'New',
            badgeColor: 'warning',
            badgeClasses: ' extra '
        );

        $this->assertStringContainsString('bg-warning', $link->badgeClasses);
        $this->assertStringContainsString('extra', $link->badgeClasses);
    }

    public function test_it_uses_livewire_navigation_when_enabled(): void
    {
        config(['ladmin.main.livewire.spa_navigation' => true]);

        $link = new DropdownLink(url: 'https://example.test/help');
        $defaultLink = new DropdownLink;

        $this->assertTrue($link->isLivewireNavigate());
        $this->assertFalse($defaultLink->isLivewireNavigate());
    }

    public function test_it_disables_livewire_navigation_if_not_enabled(): void
    {
        config(['ladmin.main.livewire.spa_navigation' => false]);

        $link = new DropdownLink(url: 'https://example.test/help');

        $this->assertFalse($link->isLivewireNavigate());
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new DropdownLink)->render();

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame(
            'ladmin::layout.navbar.dropdown-link',
            $view->getName()
        );
    }
}
