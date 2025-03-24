<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Sidebar;

use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    /**
     * The Font Awesome icon of the header.
     *
     * @var string
     */
    public $icon;

    /**
     * The label of the header.
     *
     * @var string
     */
    public $label;

    /**
     * The color theme for the header. Any Bootstrap text color, like: primary,
     * secondary, info, success, warning, danger, etc.
     *
     * @var string
     */
    public $theme;

    /**
     * Create a new component instance.
     *
     * @param  string   $label  The label text for the header
     * @param  ?string  $icon  The Font Awesome icon associated with the header
     * @param  ?string  $theme  The color theme for the header
     * @return void
     */
    public function __construct(
        string $label,
        ?string $icon = null,
        ?string $theme = null
    ) {
        $this->label = html_entity_decode($label);
        $this->icon = $icon;
        $this->theme = $theme;
    }

    /**
     * Make the set of classes for the header.
     *
     * @return string
     */
    public function makeHeaderClasses(): string
    {
        $classes = ['nav-header', 'user-select-none'];

        if (! empty($this->theme)) {
            $classes[] = "text-{$this->theme}";
        }

        return implode(' ', $classes);
    }

    /**
     * Make the set of classes for the label.
     *
     * @return string
     */
    public function makeLabelClasses(): string
    {
        $classes = [];

        if (! empty($this->icon)) {
            $classes[] = "ms-1";
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
        return view('ladmin::components.layout.sidebar.header');
    }
}
