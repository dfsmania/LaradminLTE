<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class BrandLink extends Component
{
    /**
     * The label of the brand link.
     *
     * @var string
     */
    public $label;

    /**
     * A set of extra classes for the label. You may use these classes to
     * customize the style of the label.
     *
     * @var array
     */
    public $labelClasses;

    /**
     * The URL (src attribute) of the brand link image (logo). This URL should
     * be accessible from your application.
     *
     * @var string
     */
    public $logoUrl;

    /**
     * The alternate text for the brand link logo, used as the 'alt' attribute
     * in the HTML '<img>' tag for accessibility purposes.
     *
     * @var string
     */
    public $logoAlt;

    /**
     * A set of extra classes for the logo. You may use these classes to
     * customize the logo style.
     *
     * @var array
     */
    public $logoClasses;

    /**
     * The URL (href attribute) of the brand link.
     *
     * @var string
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @param  ?string  $label  The text label for the brand link
     * @param  ?string  $logoUrl  The URL to the logo image
     * @param  string   $url  The URL the brand link points to
     * @param  string   $logoAlt  The alternative text for the logo image
     * @param  ?string  $labelClasses  Additional CSS classes for the label
     * @param  ?string  $logoClasses  Additional CSS classes for the logo
     * @return void
     */
    public function __construct(
        ?string $label = null,
        ?string $logoUrl = null,
        string $url = '#',
        string $logoAlt = '',
        ?string $labelClasses = null,
        ?string $logoClasses = null
    ) {
        $this->label = html_entity_decode($label);
        $this->logoUrl = $logoUrl;
        $this->url = $url;
        $this->logoAlt = $logoAlt;

        $this->labelClasses = ! empty($labelClasses)
            ? explode(' ', $labelClasses)
            : [];

        $this->logoClasses = ! empty($logoClasses)
            ? explode(' ', $logoClasses)
            : [];
    }

    /**
     * Make the set of classes for the label.
     *
     * @return string
     */
    public function makeLabelClasses(): string
    {
        $classes = ['brand-text'];

        if (! empty($this->labelClasses)) {
            $classes = array_merge($classes, $this->labelClasses);
        }

        return implode(' ', $classes);
    }

    /**
     * Make the set of classes for the logo.
     *
     * @return string
     */
    public function makeLogoClasses(): string
    {
        $classes = ['brand-image'];

        if (! empty($this->logoClasses)) {
            $classes = array_merge($classes, $this->logoClasses);
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.sidebar.brand-link');
    }
}
