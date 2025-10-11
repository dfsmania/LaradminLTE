<?php

namespace DFSmania\LaradminLte\View\Auth;

use Illuminate\View\Component;
use Illuminate\View\View;

class AuthLogo extends Component
{
    /**
     * The label of the authentication logo (optional).
     *
     * @var ?string
     */
    public ?string $label;

    /**
     * The set of CSS classes for the label, as a space-separated string. These
     * CSS classes are mainly used to customize the style of the label.
     *
     * @var ?string
     */
    public ?string $labelClasses;

    /**
     * The URL (src attribute) of the authentication logo image (optional).
     * This URL should be accessible from your application.
     *
     * @var ?string
     */
    public ?string $logoUrl;

    /**
     * The height of the authentication logo image. This value is used as the
     * 'height' attribute in the HTML '<img>' tag.
     *
     * @var string
     */
    public string $logoHeight;

    /**
     * The width of the authentication logo image. This value is used as the
     * 'width' attribute in the HTML '<img>' tag.
     *
     * @var string
     */
    public string $logoWidth;

    /**
     * The alternate text for the authentication logo, used as the 'alt'
     * attribute in the HTML '<img>' tag for accessibility purposes.
     *
     * @var ?string
     */
    public ?string $logoAlt;

    /**
     * The set of CSS classes for the logo, as a space-separated string. These
     * CSS classes are mainly used to customize the style of the logo.
     *
     * @var ?string
     */
    public ?string $logoClasses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Setup the label of the authentication logo.

        $this->label = html_entity_decode(
            config('ladmin.auth.logo.text', 'AdminLTE')
        );

        // Setup the authentication logo image url path, size and alternate
        // text.

        $this->logoUrl = config('ladmin.auth.logo.image', '');
        $this->logoHeight = config('ladmin.auth.logo.image_height', '55px');
        $this->logoWidth = config('ladmin.auth.logo.image_width', '55px');
        $this->logoAlt = config(
            'ladmin.auth.logo.image_alt',
            'AdminLTE Auth Logo'
        );

        // Setup the CSS classes for the label and logo image.

        $this->labelClasses = ! empty($this->label)
            ? $this->getLabelClasses()
            : null;

        $this->logoClasses = ! empty($this->logoUrl)
            ? $this->getLogoClasses()
            : null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::auth.auth-logo');
    }

    /**
     * Gets the set of CSS classes for the label.
     *
     * @return string
     */
    protected function getLabelClasses(): string
    {
        $classes = [];

        // Add classes from the configuration file.

        $cfgClasses = config('ladmin.auth.logo.text_classes', []);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, array_filter($cfgClasses));
        }

        return implode(' ', $classes);
    }

    /**
     * Gets the set of classes for the logo.
     *
     * @return string
     */
    protected function getLogoClasses(): string
    {
        $classes = [];

        // Add classes from the configuration file.

        $cfgClasses = config('ladmin.auth.logo.image_classes', []);

        if (is_array($cfgClasses)) {
            $classes = array_merge($classes, array_filter($cfgClasses));
        }

        return implode(' ', $classes);
    }
}
