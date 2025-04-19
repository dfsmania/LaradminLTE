<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Head;

use Illuminate\View\Component;
use Illuminate\View\View;

class Favicons extends Component
{
    /**
     * Determines whether to include comprehensive favicon markup to ensure
     * compatibility across various browsers and platforms. If disabled, only
     * the basic favicon markup will be included.
     *
     * @var bool
     */
    public bool $fullSupport;

    /**
     * A list of PNG favicon sizes to be served by your server. These sizes
     * are used to generate the markup for the PNG favicons discovery.
     *
     * @var string[]
     */
    public array $pngSizes;

    /**
     * The primary color of the brand logo. Used for maskable icons on iOS and
     * Android Chrome when full support is enabled.
     *
     * @var string
     */
    public string $brandLogoColor;

    /**
     * The background color of the brand logo. Used for Microsoft application
     * tiles and Android Chrome address bar when full support is enabled.
     *
     * @var string
     */
    public string $brandBackgroundColor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Initialize the component properties based on the configuration.

        $this->fullSupport = (bool) config(
            'ladmin.favicons.full_support',
            false
        );

        $this->pngSizes = $this->getPngSizes();

        $this->brandLogoColor = config(
            'ladmin.favicons.brand_logo_color',
            '#000000'
        );

        $this->brandBackgroundColor = config(
            'ladmin.favicons.brand_background_color',
            '#ffffff'
        );
    }

    /**
     * Get the PNG sizes from the configuration and ensure they are valid.
     *
     * @return string[]
     */
    protected function getPngSizes(): array
    {
        // Get the PNG sizes from the configuration and ensure they are valid.

        $sizes = config('ladmin.favicons.png_sizes', ['16x16', '32x32']);

        return array_filter($sizes, function ($size) {
            return is_string($size) && preg_match('/^\d+x\d+$/', $size);
        });
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.head.favicons');
    }
}
