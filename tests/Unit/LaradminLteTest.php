<?php

namespace DFSmania\LaradminLte\Tests\Unit;

use DFSmania\LaradminLte\Events\BuildingMenu;
use DFSmania\LaradminLte\LaradminLte;
use DFSmania\LaradminLte\Support\Menu\MenuManager;
use DFSmania\LaradminLte\Support\Plugins\PluginsManager;
use DFSmania\LaradminLte\Support\Plugins\ResourceType;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class LaradminLteTest extends TestCase
{
    public function test_defaults_when_vite_disabled_and_invalid_configs(): void
    {
        config([
            'ladmin.main.vite.enabled' => false,
            'ladmin.main.vite.input' => ['resources/js/app.js'],
            'ladmin.main.livewire.enabled' => false,
            'ladmin.main.livewire.spa_navigation' => false,
            'ladmin.menu' => 'invalid-menu-config',
            'ladmin.plugins' => 'invalid-plugin-config',
        ]);

        Event::fake([BuildingMenu::class]);

        $laradmin = new LaradminLte;

        $this->assertFalse($laradmin->isViteEnabled);
        $this->assertSame([], $laradmin->viteInput);
        $this->assertFalse($laradmin->isLivewireEnabled);
        $this->assertFalse($laradmin->isLivewireSpaEnabled);
        $this->assertInstanceOf(MenuManager::class, $laradmin->menu);
        $this->assertSame([], $laradmin->menu->getAllItems()['sidebar']);
        $this->assertSame([], $laradmin->menu->getAllItems()['navbar-left']);
        $this->assertSame([], $laradmin->menu->getAllItems()['navbar-right']);
        $this->assertInstanceOf(PluginsManager::class, $laradmin->plugins);

        $this->assertSame(
            [],
            $laradmin->plugins->getAllResources()['pre-adminlte-link']
        );

        Event::assertDispatched(BuildingMenu::class);
    }

    public function test_it_uses_vite_inputs_when_vite_is_enabled(): void
    {
        config([
            'ladmin.main.vite.enabled' => true,
            'ladmin.main.vite.input' => [
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            'ladmin.main.livewire.enabled' => true,
            'ladmin.main.livewire.spa_navigation' => true,
            'ladmin.menu' => [],
            'ladmin.plugins' => [
                'Charts' => [
                    'always' => true,
                    'resources' => [
                        [
                            'type' => ResourceType::POST_ADMINLTE_SCRIPT,
                            'source' => 'http://example.cdn.com/chart.js',
                        ],
                    ],
                ],
            ],
        ]);

        $laradmin = new LaradminLte;

        $this->assertTrue($laradmin->isViteEnabled);

        $this->assertSame(
            ['resources/js/app.js', 'resources/css/app.css'],
            $laradmin->viteInput
        );

        $this->assertTrue($laradmin->isLivewireEnabled);
        $this->assertTrue($laradmin->isLivewireSpaEnabled);

        $this->assertCount(0, $laradmin->plugins->getPreAdminlteScripts());
        $this->assertCount(0, $laradmin->plugins->getPostAdminlteScripts());
    }

    public function test_it_loads_plugin_config_when_vite_is_disabled(): void
    {
        config([
            'ladmin.main.vite.enabled' => false,
            'ladmin.menu' => [],
            'ladmin.plugins' => [
                'Charts' => [
                    'always' => true,
                    'resources' => [
                        [
                            'type' => ResourceType::POST_ADMINLTE_SCRIPT,
                            'source' => 'http://example.cdn.com/chart.js',
                        ],
                    ],
                ],
            ],
        ]);

        $laradmin = new LaradminLte;

        $this->assertFalse($laradmin->isViteEnabled);
        $this->assertSame([], $laradmin->viteInput);

        $this->assertCount(1, $laradmin->plugins->getPostAdminlteScripts());

        $this->assertSame(
            'http://example.cdn.com/chart.js',
            $laradmin->plugins->getPostAdminlteScripts()[0]->source
        );
    }
}
