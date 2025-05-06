<?php

namespace DFSmania\LaradminLte\Tools\Plugins;

use DFSmania\LaradminLte\Tools\Plugins\ResourceType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\HtmlString;
use Illuminate\View\ComponentAttributeBag;

class PluginResource
{
    /**
     * Validation rules for a plugin resource configuration. These rules are
     * used with the Laravel Validator to ensure the configuration adheres to
     * the following schema:
     *
     * (array) [
     *     'asset'  => optional|boolean,
     *     'source' => required|string,
     *     'type'   => required,
     * ]
     *
     * @var array<string, string>
     */
    protected static array $cfgValidationRules = [
        'asset' => 'sometimes|boolean',
        'source' => 'required|string',
        'type' => 'required',
    ];

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
     * Create a new PluginResource instance from a raw configuration array. It
     * will return null when the configuration is invalid.
     *
     * @param  array  $config  The raw plugin resource configuration array
     * @return ?self
     */
    public static function createFromConfig(array $config): ?self
    {
        // Ensure the resource configuration adheres to the expected schema.

        $validator = Validator::make($config, self::$cfgValidationRules);

        if ($validator->fails() || ! $config['type'] instanceof ResourceType) {
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

        $extraHtmlAttrs = Arr::except(
            $config,
            array_keys(self::$cfgValidationRules)
        );

        // At this point, configuration is valid and we return a new
        // PluginResource instance with the validated configuration.

        return new self($config['type'], $config['source'], $extraHtmlAttrs);
    }

    /**
     * Computes and returns a string (with HTML like format) that represents
     * the markup of the plugin resource.
     *
     * @return HtmlString
     */
    public function renderToHtml(): HtmlString
    {
        $htmlMarkup = null;

        if ($this->type->isLink()) {
            $htmlMarkup = $this->renderAsLink();
        } elseif ($this->type->isScript()) {
            $htmlMarkup = $this->renderAsScript();
        }

        return new HtmlString($htmlMarkup);
    }

    /**
     * Render the plugin resource as a link tag.
     *
     * @return string
     */
    protected function renderAsLink(): string
    {
        $attrs = new ComponentAttributeBag($this->htmlAttributes);

        // Add the required attributes, including the one that defines the
        // source of the link resource. Note we take priority over the html
        // attributes, so the user can override the 'href' or 'rel' attributes
        // by using the configuration, if needed.

        $attrs['href'] = $attrs['href'] ?? $this->source;
        $attrs['rel'] = $attrs['rel'] ?? 'stylesheet';

        // Return a string representing the link tag.

        return "<link {$attrs->toHtml()}>";
    }

    /**
     * Render the plugin resource as a script tag.
     *
     * @return string
     */
    protected function renderAsScript(): string
    {
        $attrs = new ComponentAttributeBag($this->htmlAttributes);

        // Add the required attributes, including the one that defines the
        // source of the script resource. Note we take priority over the html
        // attributes, so the user can override the 'src' attribute by using
        // the configuration, if needed.

        $attrs['src'] = $attrs['src'] ?? $this->source;

        // Return a string representing the script tag.

        return "<script {$attrs->toHtml()}></script>";
    }
}
