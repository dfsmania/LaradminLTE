<?php

namespace DFSmania\LaradminLte;

use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\Support\ServiceProvider;

class LaradminLteServiceProvider extends ServiceProvider
{
    /**
     * The prefix to use when registering or loading the package resources.
     *
     * @var string
     */
    protected $prefix = 'ladmin';

    /**
     * Array with the available layout components.
     *
     * @var array
     */
    protected $layoutComponents = [
        'footer' => Layout\Footer\Footer::class,
        'navbar' => Layout\Navbar\Navbar::class,
        'navbar-link' => Layout\Navbar\Link::class,
        'panel' => Layout\AdminPanel::class,
        'plugins-links' => Layout\Plugins\LinkResources::class,
        'plugins-scripts' => Layout\Plugins\ScriptResources::class,
        'sidebar' => Layout\Sidebar\Sidebar::class,
        'sidebar-brand' => Layout\Sidebar\BrandLink::class,
        'sidebar-header' => Layout\Sidebar\Header::class,
        'sidebar-link' => Layout\Sidebar\Link::class,
        'sidebar-treeview' => Layout\Sidebar\TreeviewMenu::class,
    ];

    /**
     * Register the package services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the configuration of the package.

        $this->registerConfig();
    }

    /**
     * Bootstrap the package services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Load the views of the package.

        $this->loadViews();

        // Load the blade components of the package.

        $this->loadComponents();

        // Load the translations of the package.

        $this->loadTranslations();

        // Declare the publishable resources of the package. This section is
        // only valid if the Laravel app is running on console.

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->setAssetsAsPublishable();
        $this->setConfigAsPublishable();
    }

    /**
     * Register the package configuration.
     *
     * @return void
     */
    private function registerConfig(): void
    {
        // Register the main configuration.

        $this->mergeConfigFrom(
            $this->packagePath("config/{$this->prefix}.php"),
            $this->prefix
        );

        // Register the plugins configuration.

        $this->mergeConfigFrom(
            $this->packagePath("config/{$this->prefix}_plugins.php"),
            "{$this->prefix}_plugins"
        );
    }

    /**
     * Load the package views.
     *
     * @return void
     */
    private function loadViews(): void
    {
        // Load all of the package views.

        $path = $this->packagePath('resources/views');
        $this->loadViewsFrom($path, $this->prefix);
    }

    /**
     * Load the blade view components.
     *
     * @return void
     */
    private function loadComponents(): void
    {
        // Load all the blade-x components.

        $components = array_merge(
            $this->layoutComponents,
        );

        $this->loadViewComponentsAs($this->prefix, $components);
    }

    /**
     * Load the package translations.
     *
     * @return void
     */
    private function loadTranslations(): void
    {
        $path = $this->packagePath('lang');
        $this->loadTranslationsFrom($path, $this->prefix);
    }

    /**
     * Declare the package assets as a publishable resource.
     *
     * @return void
     */
    private function setAssetsAsPublishable(): void
    {
        $path = $this->packagePath('resources/assets');

        $this->publishes([
            $path => public_path('vendor/laradmin'),
        ], 'assets');
    }

    /**
     * Declare the package config as a publishable resource.
     *
     * @return void
     */
    private function setConfigAsPublishable(): void
    {
        $mainCfg = $this->packagePath("config/{$this->prefix}.php");
        $pluginsCfg = $this->packagePath("config/{$this->prefix}_plugins.php");

        $this->publishes([
            $mainCfg => config_path("{$this->prefix}.php"),
            $pluginsCfg => config_path("{$this->prefix}_plugins.php"),
        ], 'config');
    }

    /**
     * Get the absolute path to some package resource.
     *
     * @param  string  $path  The relative path to the resource
     * @return string
     */
    private function packagePath(string $path): string
    {
        return __DIR__."/../{$path}";
    }
}
