<?php

namespace DFSmania\LaradminLte\Tools\Plugins;

use DFSmania\LaradminLte\Tools\Plugins\Plugin;
use DFSmania\LaradminLte\Tools\Plugins\PluginResource;
use DFSmania\LaradminLte\Tools\Plugins\ResourceType;

class PluginsManager
{
    /**
     * A static array to track the names of explicitly required plugins. This
     * is primarily used to store plugins required by the custom blade
     * directive: @ladmin_plugin().
     *
     * @var array<string, bool>
     */
    protected static array $explicitlyRequiredPlugins = [];

    /**
     * An array of plugin resources (primarily CSS and JS files) to be included
     * in the template. Each resource is categorized into one of the following:
     *
     * - 'pre-adminlte-link': Resources to include before the AdminLTE
     * stylesheet.
     *
     * - 'post-adminlte-link': Resources to include after the AdminLTE
     * stylesheet.
     *
     * 'pre-adminlte-script': Resources to include before the AdminLTE
     * JavaScript file.
     *
     * - 'post-adminlte-script': Resources to include after the AdminLTE
     * JavaScript file.
     *
     * @var array<string, PluginResource[]>
     */
    protected array $resources = [
        ResourceType::PRE_ADMINLTE_LINK->value => [],
        ResourceType::POST_ADMINLTE_LINK->value => [],
        ResourceType::PRE_ADMINLTE_SCRIPT->value => [],
        ResourceType::POST_ADMINLTE_SCRIPT->value => [],
    ];

    /**
     * Create a new instance of the class.
     *
     * @param  array  $pluginsCfg  An array with the raw plugins config
     * @return void
     */
    public function __construct(array $pluginsCfg = [])
    {
        // Read, validate and classify the resources of the provided plugins.

        $this->classifyPlugins($pluginsCfg);
    }

    /**
     * Mark a plugin as explicitly required.
     *
     * @param  string  $pluginName  The name of the plugin to be marked
     * @return void
     */
    public static function setPluginAsRequired(string $pluginName): void
    {
        self::$explicitlyRequiredPlugins[$pluginName] = true;
    }

    /**
     * Check if a plugin is explicitly required.
     *
     * @param  string  $pluginName  The name of the plugin to be checked
     * @return bool
     */
    public static function isPluginExplicitlyRequired(string $pluginName): bool
    {
        return self::$explicitlyRequiredPlugins[$pluginName] ?? false;
    }

    /**
     * Retrieve all the resources that have been already classified.
     *
     * @return array<string, PluginResource[]>
     */
    public function getAllResources(): array
    {
        return $this->resources;
    }

    /**
     * Retrieve the set of pre-adminlte header links.
     *
     * @return PluginResource[]
     */
    public function getPreAdminlteLinks(): array
    {
        return $this->resources[ResourceType::PRE_ADMINLTE_LINK->value];
    }

    /**
     * Retrieve the set of post-adminlte header links.
     *
     * @return PluginResource[]
     */
    public function getPostAdminlteLinks(): array
    {
        return $this->resources[ResourceType::POST_ADMINLTE_LINK->value];
    }

    /**
     * Retrieve the set of pre-adminlte scripts.
     *
     * @return PluginResource[]
     */
    public function getPreAdminlteScripts(): array
    {
        return $this->resources[ResourceType::PRE_ADMINLTE_SCRIPT->value];
    }

    /**
     * Retrieve the set of post-adminlte scripts.
     *
     * @return PluginResource[]
     */
    public function getPostAdminlteScripts(): array
    {
        return $this->resources[ResourceType::POST_ADMINLTE_SCRIPT->value];
    }

    /**
     * Read, validate and classify the resources of the provided plugins into
     * one of the available categories.
     *
     * @param  array  $plugins  An array with the raw plugins config
     * @return void
     */
    protected function classifyPlugins(array $plugins): void
    {
        foreach ($plugins as $pluginName => $pluginConfig) {
            // Create a plugin instance from the configuration. The plugin
            // instance will be null if the configuration is invalid.

            $plugin = Plugin::createFromConfig($pluginName, $pluginConfig);

            // Check if plugin is valid and required in the current request.
            // If not, skip it.

            $isPluginRequired = ! empty($pluginConfig['always'])
                || self::isPluginExplicitlyRequired($pluginName);

            if ($plugin === null || ! $isPluginRequired) {
                continue;
            }

            // Classify the resources of the plugin.

            $this->classifyResources($plugin->resources);
        }
    }

    /**
     * Read and classify the provided set of plugin resources. Invalid
     * resources in the array will be skipped.
     *
     * @param  PluginResource[]  $resources  The resources to be classified
     * @return void
     */
    protected function classifyResources(array $resources): void
    {
        // Save each resource into their corresponding category.

        foreach ($resources as $resource) {
            $this->resources[$resource->type->value][] = $resource;
        }
    }
}
