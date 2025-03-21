<?php

namespace DFSmania\LaradminLte\View\Components\Layout\MainContent;

use Illuminate\View\Component;
use Illuminate\View\View;

class MainContent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.main_content.main-content');
    }
}
