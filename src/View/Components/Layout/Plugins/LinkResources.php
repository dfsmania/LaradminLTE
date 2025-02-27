<?php

namespace DFSmania\LaradminLte\View\Components\Layout\Plugins;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class LinkResources extends Component
{
    /**
     * The array of link resources (mostly CSS files) that will be rendered.
     * These resources always belongs to one of the configured plugins.
     *
     * @var array
     */
    public $resources;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($resources = [])
    {
        // Setup the link resources.

        $this->resources = Arr::wrap($resources);
    }

    /**
     * Computes a string (with HTML like format) that represents the set of
     * attributes for the specified link resource.
     *
     * @param  array  $res  An array representing the link resource
     * @return string  A string representing the list of attributes
     */
    public function computeResourceAttributes($res)
    {
        $attrs = new ComponentAttributeBag();

        // Grab the set of attributes that were explicitly defined (these have
        // the 'attr_' token prefixed on its name), and save they into the bag.

        foreach($res as $attr => $val) {
            if (Str::startsWith($attr, 'attr_')) {
                $attrs[substr($attr, 5)] = $val;
            }
        }

        // Now, add the required attributes, including the one that references
        // the resource's source.

        $attrs['href'] = $attrs['href'] ?? $res['source'];
        $attrs['rel'] = $attrs['rel'] ?? 'stylesheet';

        // Return a string representing the list of attributes.

        return $attrs->toHtml();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ladmin::components.layout.plugins.link-resources');
    }
}
