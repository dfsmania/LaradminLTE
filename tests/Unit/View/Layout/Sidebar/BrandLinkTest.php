<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Sidebar;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Sidebar\BrandLink;
use Illuminate\View\View;

class BrandLinkTest extends TestCase
{
    public function test_it_sets_optional_brand_values_and_classes(): void
    {
        $brand = new BrandLink(
            label: 'Acme &amp; Co',
            logoUrl: '/images/logo.png',
            url: '/home',
            logoAlt: 'Acme logo',
            labelClasses: ' fw-bold ',
            logoClasses: ' rounded '
        );

        $this->assertSame('Acme & Co', $brand->label);
        $this->assertSame('/images/logo.png', $brand->logoUrl);
        $this->assertSame('/home', $brand->url);
        $this->assertSame('Acme logo', $brand->logoAlt);
        $this->assertSame('brand-text fw-bold', $brand->labelClasses);
        $this->assertSame('brand-image rounded', $brand->logoClasses);
    }

    public function test_it_uses_no_classes_if_label_or_logo_are_missing(): void
    {
        $brand = new BrandLink;

        $this->assertSame('', $brand->label);
        $this->assertNull($brand->logoClasses);
        $this->assertNull($brand->labelClasses);
        $this->assertSame('#', $brand->url);
    }

    public function test_it_falls_back_when_url_sanitization_is_empty(): void
    {
        $brand = new BrandLink(url: "\0");

        $this->assertSame('#', $brand->url);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new BrandLink)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame(
            'ladmin::layout.sidebar.brand-link',
            $view->getName()
        );
    }
}
