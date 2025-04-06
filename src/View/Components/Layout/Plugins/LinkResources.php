<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Plugins;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;

class LinkResources extends Component
{
    /**
     * The array of link resources (mostly CSS files) that will be rendered.
     * These resources always belongs to one of the configured plugins, and
     * will be validated externally.
     *
     * @var array
     */
    public array $resources;

    /**
     * Create a new component instance.
     *
     * @param  array  $resources  An array of valid link resources.
     * @return void
     */
    public function __construct(array $resources = [])
    {
        $this->resources = Arr::wrap($resources);
    }

    /**
     * Computes a string (with HTML like format) that represents the set of
     * attributes for the specified link resource.
     *
     * @param  array  $res  An array representing a valid link resource.
     * @return string
     */
    public function computeResourceAttributes(array $res): string
    {
        $attrs = new ComponentAttributeBag();

        // Grab the set of attributes that were explicitly defined (these have
        // the 'attr_' token prefixed on its name), and save they into the bag.

        foreach($res as $attr => $val) {
            if (Str::startsWith($attr, 'attr_')) {
                $attrs[substr($attr, 5)] = $val;
            }
        }

        // Now, add the required attributes, including the one that defines
        // the source of the link resource.

        $attrs['href'] = $attrs['href'] ?? ($res['source'] ?? '#');
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
