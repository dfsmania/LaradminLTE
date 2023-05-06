<?php

namespace DFSmania\LaraliveAdmin\View\Components\Layout\Sidebar;

use Illuminate\View\Component;

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
     * The AdminLTE theme for the header (primary, secondary, info, success,
     * warning, danger, light, dark, black, white).
     *
     * @var string
     */
    public $theme;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $icon = null, $theme = null)
    {
        $this->label = html_entity_decode($label);
        $this->icon = $icon;
        $this->theme = $theme;
    }

    /**
     * Make the set of classes for the header.
     *
     * @return string
     */
    public function makeHeaderClasses()
    {
        $classes = ['nav-header'];

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
    public function makeLabelClasses()
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
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.sidebar.header');
    }
}
