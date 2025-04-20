<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Plugins;

use DFSmania\LaradminLte\Tools\Plugins\PluginResource;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;

class LinkResources extends Component
{
    /**
     * The array of link resources (PluginResource instances) that will be
     * rendered.
     *
     * @var PluginResource[]
     */
    public array $resources;

    /**
     * Create a new component instance.
     *
     * @param  PluginResource[]  $resources  An array of valid link resources.
     * @return void
     */
    public function __construct(array $resources = [])
    {
        $this->resources = $resources;
    }

    /**
     * Computes a string (with HTML like format) that represents the set of
     * attributes for the specified link resource.
     *
     * @param  PluginResource  $res  A valid link resource.
     * @return string
     */
    public function computeResourceAttributes(PluginResource $res): string
    {
        $attrs = new ComponentAttributeBag($res->htmlAttributes);

        // Add the required attributes, including the one that defines the
        // source of the link resource.

        $attrs['href'] = $attrs['href'] ?? $res->source;
        $attrs['rel'] = $attrs['rel'] ?? 'stylesheet';

        // Return a string representing the list of attributes for the link.

        return $attrs->toHtml();
    }

    /**
     * Get the view / contents that represent the component.
     * This method will be used to render the set of link resources that were
     * configured for the head tag.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::components.layout.plugins.link-resources');
    }
}
