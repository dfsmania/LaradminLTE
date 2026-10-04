<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Plugins;

use DFSmania\LaradminLte\Support\Plugins\Plugin;
use DFSmania\LaradminLte\Support\Plugins\PluginResource;
use DFSmania\LaradminLte\Support\Plugins\PluginsManager;
use DFSmania\LaradminLte\Support\Plugins\ResourceType;
use DFSmania\LaradminLte\Tests\TestCase;

class PluginsTest extends TestCase
{
    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_resource_types_identify_links_and_scripts(): void
    {
        $this->assertTrue(ResourceType::PRE_ADMINLTE_LINK->isLink());
        $this->assertTrue(ResourceType::POST_ADMINLTE_LINK->isLink());
        $this->assertTrue(ResourceType::PRE_ADMINLTE_SCRIPT->isScript());
        $this->assertTrue(ResourceType::POST_ADMINLTE_SCRIPT->isScript());
        $this->assertFalse(ResourceType::PRE_ADMINLTE_LINK->isScript());
        $this->assertFalse(ResourceType::POST_ADMINLTE_SCRIPT->isLink());
    }

    public function test_it_builds_and_renders_link_resources(): void
    {
        $resource = PluginResource::createFromConfig([
            'type' => ResourceType::PRE_ADMINLTE_LINK,
            'source' => 'https://example.com/app.css',
            'media' => 'screen',
        ]);

        $this->assertInstanceOf(PluginResource::class, $resource);

        $html = (string) $resource->renderToHtml();

        $this->assertStringContainsString('<link', $html);
        $this->assertStringContainsString(
            'href="https://example.com/app.css"',
            $html
        );
        $this->assertStringContainsString('media="screen"', $html);
    }

    public function test_it_builds_and_renders_script_resources(): void
    {
        $resource = PluginResource::createFromConfig([
            'type' => ResourceType::POST_ADMINLTE_SCRIPT,
            'source' => 'https://example.com/app.js',
            'defer' => true,
        ]);

        $html = (string) $resource->renderToHtml();

        $this->assertStringContainsString('<script', $html);
        $this->assertStringContainsString(
            'src="https://example.com/app.js"',
            $html
        );
        $this->assertStringContainsString('defer', $html);
    }

    public function test_it_rejects_invalid_resources(): void
    {
        $this->assertNull(PluginResource::createFromConfig([]));

        $this->assertNull(PluginResource::createFromConfig([
            'type' => 'invalid',
            'source' => 'https://example.com/app.css',
        ]));

        $this->assertNull(PluginResource::createFromConfig([
            'type' => ResourceType::PRE_ADMINLTE_LINK,
            'source' => 'not-a-url',
        ]));
    }

    public function test_it_accepts_asset_sources(): void
    {
        $resource = PluginResource::createFromConfig([
            'asset' => true,
            'type' => ResourceType::PRE_ADMINLTE_LINK,
            'source' => 'css/app.css',
        ]);

        $this->assertInstanceOf(PluginResource::class, $resource);
        $this->assertStringContainsString('/css/app.css', $resource->source);
    }

    public function test_it_builds_plugins_and_filters_invalid_resources(): void
    {
        $emptyPlugin = new Plugin('Empty');
        $this->assertSame('Empty', $emptyPlugin->name);
        $this->assertSame([], $emptyPlugin->resources);

        $plugin = Plugin::createFromConfig('Demo', [
            'resources' => [
                [
                    'type' => ResourceType::PRE_ADMINLTE_LINK,
                    'source' => 'https://example.com/a.css',
                ],
                [
                    'type' => ResourceType::PRE_ADMINLTE_LINK,
                    'source' => 'invalid',
                ],
            ],
        ]);

        $this->assertInstanceOf(Plugin::class, $plugin);
        $this->assertSame('Demo', $plugin->name);
        $this->assertCount(1, $plugin->resources);
    }

    public function test_it_rejects_invalid_plugins(): void
    {
        $invalidPlugin = Plugin::createFromConfig(
            'Invalid',
            ['resources' => []]
        );

        $this->assertNull($invalidPlugin);

        $invalidPlugin2 = Plugin::createFromConfig(
            'Invalid',
            ['resources' => [
                [
                    'type' => ResourceType::PRE_ADMINLTE_LINK,
                    'source' => 'invalid',
                ],
            ]]
        );

        $this->assertNull($invalidPlugin2);

        $invalidPlugin3 = Plugin::createFromConfig(
            'Invalid',
            ['always' => 'yes']
        );

        $this->assertNull($invalidPlugin3);
    }

    public function test_manager_classifies_always_and_explicit_plugins(): void
    {
        PluginsManager::setPluginAsRequired('Explicit');
        $manager = new PluginsManager([
            'Always' => [
                'always' => true,
                'resources' => [[
                    'type' => ResourceType::PRE_ADMINLTE_LINK,
                    'source' => 'https://example.com/always.css',
                ]],
            ],
            'Explicit' => [
                'resources' => [[
                    'type' => ResourceType::POST_ADMINLTE_SCRIPT,
                    'source' => 'https://example.com/explicit.js',
                ]],
            ],
            'Ignored' => [
                'resources' => [[
                    'type' => ResourceType::PRE_ADMINLTE_LINK,
                    'source' => 'https://example.com/ignored.css',
                ]],
            ],
        ]);

        $this->assertTrue(
            PluginsManager::isPluginExplicitlyRequired('Explicit')
        );
        $this->assertFalse(
            PluginsManager::isPluginExplicitlyRequired('Missing')
        );
        $this->assertCount(1, $manager->getPreAdminlteLinks());
        $this->assertCount(1, $manager->getPostAdminlteScripts());
        $this->assertCount(0, $manager->getPostAdminlteLinks());
        $this->assertCount(0, $manager->getPreAdminlteScripts());
        $this->assertArrayHasKey(
            'pre-adminlte-link',
            $manager->getAllResources()
        );
    }

    public function test_manager_filters_resources_by_type(): void
    {
        config([
            'ladmin.plugins.Demo' => [
                'resources' => [
                    [
                        'type' => ResourceType::PRE_ADMINLTE_LINK,
                        'source' => 'https://example.com/demo.css',
                    ],
                    [
                        'type' => ResourceType::PRE_ADMINLTE_SCRIPT,
                        'source' => 'https://example.com/demo.js',
                    ],
                ],
            ],
        ]);

        $manager = new PluginsManager;

        $this->assertCount(2, $manager->getPluginResources('Demo'));
        $this->assertCount(2, $manager->getPluginResources(['Demo']));
        $this->assertCount(1, $manager->getPluginResources(
            'Demo',
            ResourceType::PRE_ADMINLTE_SCRIPT
        ));
        $this->assertCount(0, $manager->getPluginResources(['Missing']));

        config(['ladmin.plugins.Invalid' => ['resources' => 'invalid']]);
        $this->assertCount(0, $manager->getPluginResources('Invalid'));
    }
}
