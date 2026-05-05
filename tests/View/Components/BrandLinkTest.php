<?php

namespace DFSmania\LaradminLte\Tests\View\Components;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Sidebar\BrandLink;
use Illuminate\View\Component;

class BrandLinkTest extends TestCase
{
    /**
     * Test that the brand link component renders with correct URL.
     *
     * @return void
     */
    public function test_brand_link_uses_configured_url()
    {
        // Test default URL fallback
        $component = new BrandLink(
            label: 'Test',
            logoUrl: null,
            url: '#'
        );

        $this->assertEquals('#', $component->url);

        // Test custom URL
        $component = new BrandLink(
            label: 'Test',
            logoUrl: null,
            url: '/dashboard'
        );

        $this->assertEquals('/dashboard', $component->url);

        // Test that URL is passed through as-is (any string is accepted)
        $component = new BrandLink(
            label: 'Test',
            logoUrl: null,
            url: 'https://example.com'
        );

        $this->assertEquals('https://example.com', $component->url);
    }

    /**
     * Test that the component extends the correct base class.
     *
     * @return void
     */
    public function test_component_extends_view_component()
    {
        $component = new BrandLink;

        $this->assertInstanceOf(Component::class, $component);
    }
}
