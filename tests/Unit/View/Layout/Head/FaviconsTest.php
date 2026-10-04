<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Layout\Head;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Layout\Head\Favicons;
use Illuminate\View\View;

class FaviconsTest extends TestCase
{
    public function test_it_sets_defaults_from_configuration(): void
    {
        $favicons = new Favicons;

        $this->assertTrue($favicons->fullSupport);
        $this->assertSame(
            ['16x16', '32x32', '96x96'],
            array_values($favicons->pngSizes)
        );
        $this->assertSame('#000000', $favicons->brandLogoColor);
        $this->assertSame('#ffffff', $favicons->brandBackgroundColor);
    }

    public function test_it_enables_full_support_from_configuration(): void
    {
        config(['ladmin.main.favicons.full_support' => true]);

        $favicons = new Favicons;

        $this->assertTrue($favicons->fullSupport);
    }

    public function test_it_filters_out_invalid_png_sizes(): void
    {
        config([
            'ladmin.main.favicons.png_sizes' => [
                '16x16',
                'invalid',
                123,
                '64x64',
            ],
        ]);

        $favicons = new Favicons;

        $this->assertSame(
            ['16x16', '64x64'],
            array_values($favicons->pngSizes)
        );
    }

    public function test_it_reads_brand_colors_from_configuration(): void
    {
        config([
            'ladmin.main.favicons.brand_logo_color' => '#123456',
            'ladmin.main.favicons.brand_background_color' => '#abcdef',
        ]);

        $favicons = new Favicons;

        $this->assertSame('#123456', $favicons->brandLogoColor);
        $this->assertSame('#abcdef', $favicons->brandBackgroundColor);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Favicons)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::layout.head.favicons', $view->getName());
    }
}
