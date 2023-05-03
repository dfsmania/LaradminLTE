<?php

namespace DFSmania\LaraliveAdmin\View\Components\Layout\Sidebar;

use Illuminate\View\Component;

class BrandLink extends Component
{
    /**
     * The label of the brand link.
     *
     * @var string
     */
    public $label;

    /**
     * A set of extra classes for the label. You may use this to customize the
     * label style.
     *
     * @var string
     */
    public $labelClasses;

    /**
     * The image path (logo) of the brand link.
     *
     * @var string
     */
    public $logo;

    /**
     * The alternate text for the logo of the brand link. The HTML engine will
     * use this text when the logo could not be displayed.
     *
     * @var string
     */
    public $logoAlt;

    /**
     * A set of extra classes for the logo. You may use this to customize the
     * logo style.
     *
     * @var string
     */
    public $logoClasses;

    /**
     * The URL of the brand link.
     *
     * @var string
     */
    public $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $label = null, $logo = null, $url = '#', $logoAlt = '',
        $labelClasses = null, $logoClasses = null
    ) {
        $this->label = html_entity_decode($label);
        $this->logo = $logo;
        $this->url = $url;
        $this->logoAlt = $logoAlt;
        $this->labelClasses = $labelClasses;
        $this->logoClasses = $logoClasses;
    }

    /**
     * Make the set of classes for the label.
     *
     * @return string
     */
    public function makeLabelClasses()
    {
        $classes = ['brand-text'];

        if (! empty($this->labelClasses)) {
            $classes[] = $this->labelClasses;
        }

        return implode(' ', $classes);
    }

    /**
     * Make the set of classes for the logo.
     *
     * @return string
     */
    public function makeLogoClasses()
    {
        $classes = ['brand-image'];

        if (! empty($this->logoClasses)) {
            $classes[] = $this->logoClasses;
        }

        return implode(' ', $classes);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.sidebar.brand-link');
    }
}
