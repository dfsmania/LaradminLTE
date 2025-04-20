<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Plugins;

use DFSmania\LaradminLte\Tools\Plugins\PluginResource;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;

class ScriptResources extends Component
{
    /**
     * The array of script resources (PluginResource instances) that will be
     * rendered.
     *
     * @var PluginResource[]
     */
    public array $resources;

    /**
     * Create a new component instance.
     *
     * @param  PluginResource[]  $resources  An array of valid script resources.
     * @return void
     */
    public function __construct(array $resources = [])
    {
        $this->resources = $resources;
    }

    /**
     * Computes a string (with HTML like format) that represents the set of
     * attributes for the specified script resource.
     *
     * @param  PluginResource  $res  A valid script resource.
     * @return string
     */
    public function computeResourceAttributes(PluginResource $res): string
    {
        $attrs = new ComponentAttributeBag($res->htmlAttributes);

        // Add the required attributes, including the one that defines
        // the source of the script resource.

        $attrs['src'] = $attrs['src'] ?? $res->source;

        // Return a string representing the list of attributes for the script.

        return $attrs->toHtml();
    }

    /**
     * Get the view / contents that represent the component.
     * This method will be used to render the set of script resources that were
     * configured for the body tag.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.plugins.script-resources');
    }
}
