<?php

namespace DFSmania\LaradminLte\Tools\Plugins;

use DFSmania\LaradminLte\Tools\Plugins\PluginResource;

class Plugin
{
    /**
     * The name of the plugin.
     *
     * @var string
     */
    public string $name;

    /**
     * Whether the plugin is always required. If a plugin is always required,
     * its resources will be included into all the views using the AdminLTE
     * layout template.
     *
     * @var bool
     */
    public bool $always;

    /**
     * The list of resources associated with the plugin. Each resource is an
     * instance of PluginResource and represents a CSS or JS file required
     * by the plugin.
     *
     * @var PluginResource[]
     */
    public array $resources;

    /**
     * Create a new Plugin instance.
     *
     * @param  string  $name  The name of the plugin
     * @param  bool  $always  Whether the plugin is always required
     * @param  PluginResource[]  $resources  The list of plugin resources
     * @return void
     */
    public function __construct(
        string $name,
        bool $always,
        array $resources = []
    ) {
        $this->name = $name;
        $this->always = $always;
        $this->resources = $resources;
    }

    /**
     * Create a new Plugin instance from a raw plugin configuration array. It
     * will return null when the configuration is invalid or when no valid
     * resources are found in the configuration.
     *
     * @param  string  $name  The plugin name
     * @param  array  $config  The plugin raw configuration array
     * @return ?self
     */
    public static function createFromConfig(string $name, array $config): ?self
    {
        // Ensure the plugin configuration adheres to the expected schema.

        if (! self::validatePluginConfig($config)) {
            return null;
        }

        // Retrieve the set of valid plugin resources. If no valid resources
        // were found, return null.

        $resources = self::createResourcesFromConfig($config['resources']);

        if (empty($resources)) {
            return null;
        }

        // At this point, configuration is valid and we return a new Plugin
        // instance with the validated configuration.

        return new self($name, $config['always'], $resources);
    }

    /**
     * Validate a plugin raw configuration. A plugin configuration should
     * follow the below schema:
     *
     * (array) [
     *     'always'    => required|bool,
     *     'resources' => required|array,
     * ]
     *
     * @param  array  $config  The raw plugin configuration array
     * @return bool
     */
    protected static function validatePluginConfig(array $config): bool
    {
        return isset($config['always'], $config['resources'])
            && is_bool($config['always'])
            && is_array($config['resources'])
            && ! empty($config['resources']);
    }

    /**
     * Create a set of PluginResource instances from a raw plugin resources
     * configuration array. Each resource in the configuration should follow
     * the below schema:
     *
     * (array) [
     *     'asset'  => optional|bool,
     *     'source' => required|string,
     *     'type'   => required|string,
     * ]
     *
     * @param  array  $resources  The raw plugin resources configuration array
     * @return PluginResource[]
     */
    protected static function createResourcesFromConfig(array $resources): array
    {
        $result = [];

        foreach ($resources as $resConfig) {
            $resource = PluginResource::createFromConfig($resConfig);

            if ($resource !== null) {
                $result[] = $resource;
            }
        }

        return $result;
    }

    /**
     * Check if the plugin is required.
     * TODO: Consider enhancing the logic to determine if the plugin is required
     * by evaluating its usage in the current request or view. This could be
     * achieved using a custom Blade directive or another mechanism. For now,
     * the plugin is either always required (on all views) or never required.
     * TODO: Explore the possibility of defining a custom Blade directive to
     * dynamically modify a plugin's configuration property. For example, a
     * directive like @ladmin-plugin('foo') could set:
     * config(['ladmin_plugins.foo.required' => true])
     * This would only apply if the 'foo' plugin exists in the plugins
     * configuration.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->always;
    }
}
