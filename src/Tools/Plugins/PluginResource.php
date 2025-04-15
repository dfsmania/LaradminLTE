<?php

namespace DFSmania\LaradminLte\Tools\Plugins;

use DFSmania\LaradminLte\Tools\Plugins\ResourceType;
use Illuminate\Support\Arr;

class PluginResource
{
    /**
     * The type of the resource, indicating its placement within the HTML
     * document relative to the AdminLTE CSS and JS files.
     *
     * @var ResourceType
     */
    public ResourceType $type;

    /**
     * The source URL of the resource.
     *
     * @var string
     */
    public string $source;

    /**
     * Additional HTML attributes for the resource. These attributes will be
     * rendered as extra HTML attributes on the resource tag.
     *
     * @var array
     */
    public array $htmlAttributes;

    /**
     * Create a new PluginResource instance.
     *
     * @param  ResourceType  $type  The type of the resource
     * @param  string  $source  The source URL of the resource
     * @param  array  $attributes  Additional HTML attributes for the resource
     * @return void
     */
    public function __construct(
        ResourceType $type,
        string $source,
        array $attributes = []
    ) {
        $this->type = $type;
        $this->source = $source;
        $this->htmlAttributes = $attributes;
    }

    /**
     * Create a PluginResource instance from a raw configuration array. It will
     * return null when the configuration is invalid.
     *
     * @param  array  $config  The raw plugin resource configuration array
     * @return ?self
     */
    public static function createFromConfig(array $config): ?self
    {
        // Ensure the resource configuration adheres to the expected schema.

        if (! self::validateResourceConfig($config)) {
            return null;
        }

        // Handle the asset config property, and verify the source has a valid
        // URL.

        if (! empty($config['asset'])) {
            $config['source'] = asset($config['source']);
        }

        if (! filter_var($config['source'], FILTER_VALIDATE_URL)) {
            return null;
        }

        // Retrieve additional attributes for the resource. These attributes
        // will be rendered as extra HTML attributes on the resource tag.

        $htmlExtraAttrs = Arr::except($config, ['type', 'source', 'asset']);

        // At this point, configuration is valid and we return a new
        // PluginResource instance with the validated configuration.

        return new self($config['type'], $config['source'], $htmlExtraAttrs);
    }

    /**
     * Validate a plugin resource raw configuration. A resource configuration
     * should follow the below schema:
     *
     * (array) [
     *     'asset'  => optional|bool,
     *     'source' => required|string,
     *     'type'   => required|ResourceType,
     * ]
     *
     * Any other extra property in the configuration will be considered as an
     * extra attribute for the resource tag.
     *
     * @param  array  $config  The raw plugin resource configuration array
     * @return bool
     */
    protected static function validateResourceConfig(array $config): bool
    {
        // Check if the configuration has valid source (required).

        $hasValidSource = ! empty($config['source'])
            && is_string($config['source']);

        // Check if the configuration has valid type (required).

        $hasValidType = ! empty($config['type'])
            && $config['type'] instanceof ResourceType;

        // Check if the configuration has valid asset (optional).

        $hasValidAsset = ! array_key_exists('asset', $config)
            || is_bool($config['asset']);

        // Returns whether the resource configuration is valid.

        return $hasValidSource && $hasValidType && $hasValidAsset;
    }
}
