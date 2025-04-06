<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class BrandLink extends Component
{
    /**
     * The label of the brand link (optional).
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
     * The URL (src attribute) of the brand link image (optional). This URL
     * should be accessible from your application.
     *
     * @var ?string
     */
    public ?string $logoUrl;

    /**
     * The alternate text for the brand link logo, used as the 'alt' attribute
     * in the HTML '<img>' tag for accessibility purposes.
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
     * The URL (href attribute) of the brand link.
     *
     * @var string
     */
    public string $url;

    /**
     * Create a new component instance.
     *
     * @param  ?string  $label  The text label for the brand link
     * @param  ?string  $logoUrl  The URL to the logo image
     * @param  string   $url  The URL the brand link points to
     * @param  ?string  $logoAlt  The alternative text for the logo image
     * @param  ?string  $labelClasses  Additional CSS classes for the label
     * @param  ?string  $logoClasses  Additional CSS classes for the logo
     * @return void
     */
    public function __construct(
        ?string $label = null,
        ?string $logoUrl = null,
        string $url = '#',
        ?string $logoAlt = null,
        ?string $labelClasses = null,
        ?string $logoClasses = null
    ) {
        $this->label = html_entity_decode($label);
        $this->logoUrl = $logoUrl;
        $this->url = filter_var($url, FILTER_SANITIZE_URL) ? $url : '#';
        $this->logoAlt = $logoAlt;

        $this->labelClasses = ! empty($label)
            ? $this->getLabelClasses($labelClasses)
            : null;

        $this->logoClasses = ! empty($logoUrl)
            ? $this->getLogoClasses($logoClasses)
            : null;
    }

    /**
     * Gets the set of CSS classes for the label.
     *
     * @param  ?string  $extraClasses  A set of extra CSS classes for the label
     * @return string
     */
    protected function getLabelClasses(?string $extraClasses): string
    {
        $classes = ['brand-text'];

        if (! empty($extraClasses)) {
            $classes[] = trim($extraClasses);
        }

        return implode(' ', $classes);
    }

    /**
     * Gets the set of classes for the logo.
     *
     * @param  ?string  $extraClasses  A set of extra CSS classes for the logo
     * @return string
     */
    protected function getLogoClasses(?string $extraClasses): string
    {
        $classes = ['brand-image'];

        if (! empty($extraClasses)) {
            $classes[] = trim($extraClasses);
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
