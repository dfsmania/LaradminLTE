<?php

namespace DFSmania\LaradminLte\Support\Installation;

use Illuminate\Support\Collection;

/**
 * Class responsible for cataloging publishable resources in the LaradminLTE
 * package.
 */
class PublishableResourceCatalog
{
    /**
     * The collection of publishable resources managed by this class.
     *
     * @var Collection<string, PublishableResource>
     */
    private Collection $resources;

    /**
     * Create a new publishable resource manager instance.
     */
    public function __construct()
    {
        // Initialize the collection of publishable resources.

        $assets = new PublishableResource(
            key: 'assets',
            name: 'AdminLTE assets',
            tag: 'ladmin-assets',
            required: true,
            help: 'The AdminLTE 4 assets (distribution files).',
        );

        $config = new PublishableResource(
            key: 'config',
            name: 'Configuration',
            tag: 'ladmin-config',
            required: true,
            help: 'The configuration files for LaradminLTE.',
        );

        $translations = new PublishableResource(
            key: 'translations',
            name: 'Translations',
            tag: 'ladmin-translations',
            required: false,
            help: 'Allows you to customize translations or add new languages.',
        );

        $migrations = new PublishableResource(
            key: 'migrations',
            name: 'Migrations',
            tag: 'ladmin-migrations',
            required: false,
            help: 'Required for user profile images when using authentication.',
        );

        // Collect all publishable resources into the collection.

        $this->resources = collect([
            $assets,
            $config,
            $translations,
            $migrations,
        ])->keyBy(fn (PublishableResource $resource) => $resource->key);
    }

    /**
     * Get all publishable resources.
     *
     * @return Collection<string, PublishableResource>
     */
    public function all(): Collection
    {
        return $this->resources;
    }

    /**
     * Get all required publishable resources.
     *
     * @return Collection<string, PublishableResource>
     */
    public function required(): Collection
    {
        return $this->resources->filter(
            fn (PublishableResource $resource) => $resource->isRequired()
        );
    }

    /**
     * Get all optional publishable resources.
     *
     * @return Collection<string, PublishableResource>
     */
    public function optional(): Collection
    {
        return $this->resources->filter(
            fn (PublishableResource $resource) => $resource->isOptional()
        );
    }

    /**
     * Get a publishable resource by its key.
     *
     * @param  string  $key
     * @return PublishableResource|null
     */
    public function get(string $key): ?PublishableResource
    {
        return $this->resources->get($key);
    }
}
