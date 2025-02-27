<?php

namespace DFSmania\LaradminLte\Tools\Plugins;

class PluginsManager
{
    /**
     * The array of plugins resources (mostly CSS and JS files) that will be
     * included into the template. Each resource is classified into one of
     * the next categories:
     *
     * > resources['pre-adminlte-link']: Resources to be included before the
     * AdminLTE Stylesheet.
     *
     * > resources['post-adminlte-link']: Resources to be included after the
     * AdminLTE Stylesheet.
     *
     * > resources['pre-adminlte-script']: Resources to be included before the
     * AdminLTE Javascript file.
     *
     * > resources['post-adminlte-script']: Resources to be included after the
     * AdminLTE Javascript file.
     *
     * @var array
     */
    protected $resources = [
        'pre-adminlte-link' => [],
        'post-adminlte-link' => [],
        'pre-adminlte-script' => [],
        'post-adminlte-script' => [],
    ];

    /**
     * Create a new instance of the class.
     *
     * @param  array  $plugins  An array with the plugins resources
     * @return void
     */
    public function __construct($plugins = [])
    {
        // Read and classify the resources of the provided plugins.

        $this->classifyPlugins(is_array($plugins) ? $plugins : []);
    }

    /**
     * Retrieve all the resources that have been already classified.
     *
     * @return array
     */
    public function getAllResources()
    {
        return $this->resources;
    }

    /**
     * Retrieve the set of pre-adminlte header links.
     *
     * @return array
     */
    public function getPreAdminlteLinks()
    {
        return $this->resources['pre-adminlte-link'] ?? [];
    }

    /**
     * Retrieve the set of post-adminlte header links.
     *
     * @return array
     */
    public function getPostAdminlteLinks()
    {
        return $this->resources['post-adminlte-link'] ?? [];
    }

    /**
     * Retrieve the set of pre-adminlte scripts.
     *
     * @return array
     */
    public function getPreAdminlteScripts()
    {
        return $this->resources['pre-adminlte-script'] ?? [];
    }

    /**
     * Retrieve the set of post-adminlte scripts.
     *
     * @return array
     */
    public function getPostAdminlteScripts()
    {
        return $this->resources['post-adminlte-script'] ?? [];
    }

    /**
     * Read and classify the resources of the provided plugins into one of the
     * available categories.
     *
     * @param  array  $plugins  An array with the plugins resources
     * @return void
     */
    protected function classifyPlugins($plugins)
    {
        foreach ($plugins as $pluginName => $plugin) {

            // Check whether the plugin should be included.

            if (! $this->shouldIncludePlugin($plugin)) {
                continue;
            }

            // Now, classify the resources of the plugin.

            $this->classifyResources($plugin['resources']);
        }
    }

    /**
     * Read and classify the provided set of plugin resources.
     *
     * @param  array  $resources  An array with the resources to be classified
     * @return void
     */
    protected function classifyResources($resources)
    {
        foreach ($resources as $res) {

            // Check whether the plugin resource is valid.

            if (! $this->isValidPluginResource($res)) {
                continue;
            }

            // Now, classify the plugin resource.

            $this->classifyResource($res);
        }
    }

    /**
     * Classify the specified resource into one of the next categories:
     * > pre-adminlte-link
     * > post-adminlte-link
     * > pre-adminlte-script
     * > post-adminlte-script
     *
     * @param  array  $resource  An array describing the resource
     * @return void
     */
    protected function classifyResource($resource)
    {
        // Pre-process the source attribute of the resource.

        if (! empty($resource['asset'])) {
            $resource['source'] = asset($resource['source']);
        }

        // Add the resource into its category (note we clean some properties
        // before adding the resource in the corresponding category).

        $type = $resource['type'];
        unset($resource['type']);
        unset($resource['asset']);
        $this->resources[$type][] = $resource;
    }

    /**
     * Checks whether a plugin should be included. A plugin should be included
     * when it's valid and required in the current request or view.
     *
     * @param  array  $plugin  An array representing the plugin
     * @return bool  Whether the plugin should be included or not
     */
    protected function shouldIncludePlugin($plugin)
    {
        return $this->isValidPlugin($plugin)
            && $this->isRequiredPlugin($plugin);
    }

    /**
     * Checks if the structure of a plugin is valid (i.e. contains the required
     * data). A plugin should follow the below schema:
     *
     * (array) [
     *     'always'    => required|bool,
     *     'resources' => required|array,
     * ]
     *
     * @param  array  $plugin  An array representing the plugin data
     * @return bool  Whether the plugin structure is valid or not
     */
    protected function isValidPlugin($plugin)
    {
        return is_array($plugin)
            && isset($plugin['always'])
            && isset($plugin['resources'])
            && is_array($plugin['resources'])
            && ! empty($plugin['resources']);
    }

    /**
     * Checks whether a plugin is currently required. A plugin is required when
     * the 'always' property is set, or when it's explicitly required by the
     * current request/view using a custom blade directive (TBD).
     *
     * @param  array  $plugin  An array representing the plugin data
     * @return bool  Whether the plugin must be included or not
     */
    protected function isRequiredPlugin($plugin)
    {
        // TODO: We should also check whether the plugin is required by the
        // current request/view using some sort of blade directive (TBD). By
        // the moment, it's always (on all views) or never required.
        // TODO: Check whether it's possible to define a new custom blade
        // directive that changes a plugin configuration property. For example:
        // a directive @ladmin-plugin('foo') that sets:
        // config(['ladmin_plugins.foo.required' => true])
        // Obviously, if the configuration entry for 'foo' exists in the
        // plugins configuration.

        return ! empty($plugin['always']);
    }

    /**
     * Checks whether the structure of a plugin resource is valid (i.e.
     * contains the required data). A resource should follow the below schema:
     *
     * (array) [
     *     'asset'  => optional|bool,
     *     'source' => required|string,
     *     'type'   => required|string,
     * ]
     *
     * @param  array  $resource  An array representing the plugin resource
     * @return bool  Whether the resource structure is valid or not
     */
    protected function isValidPluginResource($resource)
    {
        // Note that a resource with an unaccepted type with be detected as
        // invalid. A type should match with one of the available
        // classification categories.

        return is_array($resource)
            && isset($resource['source'])
            && isset($resource['type'])
            && in_array($resource['type'], array_keys($this->resources));
    }
}
