<?php

namespace DFSmania\LaradminLte\Tools\Plugins;

use Illuminate\Support\Facades\Validator;

class Plugin
{
    /**
     * Validation rules for a plugin configuration. These rules are used with
     * the Laravel Validator to ensure the configuration adheres to the
     * following schema:
     *
     * (array) [
     *     'always'    => optional|boolean,
     *     'resources' => required|array,
     * ]
     *
     * @var array<string, string>
     */
    protected static array $cfgValidationRules = [
        'always' => 'sometimes|boolean',
        'resources' => 'required|array',
    ];

    /**
     * The name of the plugin.
     *
     * @var string
     */
    public string $name;

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
     * @param  PluginResource[]  $resources  The list of plugin resources
     * @return void
     */
    public function __construct(string $name, array $resources = [])
    {
        $this->name = $name;
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

        $validator = Validator::make($config, self::$cfgValidationRules);

        if ($validator->fails()) {
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

        return new self($name, $resources);
    }

    /**
     * Create a set of PluginResource instances from a raw plugin resources
     * configuration array. It will return an empty array when no valid
     * resources are found in the configuration.
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
}
