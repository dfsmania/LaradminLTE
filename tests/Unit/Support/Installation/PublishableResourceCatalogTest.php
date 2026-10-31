<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Installation;

use DFSmania\LaradminLte\Support\Installation\PublishableResource;
use DFSmania\LaradminLte\Support\Installation\PublishableResourceCatalog;
use DFSmania\LaradminLte\Tests\TestCase;

class PublishableResourceCatalogTest extends TestCase
{
    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_provides_all_publishable_resources(): void
    {
        $catalog = new PublishableResourceCatalog;
        $resources = $catalog->all();

        // Ensure the catalog provides all expected publishable resources.

        $this->assertCount(4, $resources);
        $this->assertSame([
            'assets',
            'config',
            'translations',
            'migrations',
        ], $resources->keys()->all());

        // Ensure each resource has the correct key and is an instance of
        // PublishableResource.

        foreach ($resources as $key => $resource) {
            $this->assertInstanceOf(PublishableResource::class, $resource);
            $this->assertSame($key, $resource->key);
        }
    }

    public function test_it_provides_required_resources(): void
    {
        $catalog = new PublishableResourceCatalog;
        $resources = $catalog->required();

        // Ensure the catalog provides all expected required resources.

        $this->assertSame([
            'assets',
            'config',
        ], $resources->keys()->all());

        // Ensure each resource is marked as required.

        foreach ($resources as $resource) {
            $this->assertTrue($resource->isRequired());
        }
    }

    public function test_it_provides_optional_resources(): void
    {
        $catalog = new PublishableResourceCatalog;
        $resources = $catalog->optional();

        // Ensure the catalog provides all expected optional resources.

        $this->assertSame([
            'translations',
            'migrations',
        ], $resources->keys()->all());

        // Ensure each resource is marked as optional.

        foreach ($resources as $resource) {
            $this->assertTrue($resource->isOptional());
        }
    }

    public function test_it_retrieves_a_resource_by_key(): void
    {
        $catalog = new PublishableResourceCatalog;
        $resource = $catalog->get('config');

        // Ensure the catalog retrieves the correct resource by its key.

        $this->assertInstanceOf(PublishableResource::class, $resource);
        $this->assertSame('config', $resource->key);
        $this->assertSame('Configuration', $resource->name);
        $this->assertSame('ladmin-config', $resource->tag);
    }

    public function test_it_returns_null_for_an_unknown_resource_key(): void
    {
        $catalog = new PublishableResourceCatalog;

        $this->assertNull($catalog->get('unknown'));
    }
}
