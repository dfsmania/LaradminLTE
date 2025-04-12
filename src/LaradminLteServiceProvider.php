<?php

namespace DFSmania\LaradminLte;

use DFSmania\LaradminLte\View\Components\Layout;
use Illuminate\Support\ServiceProvider;

class LaradminLteServiceProvider extends ServiceProvider
{
    /**
     * The prefix used for registering and loading package resources.
     *
     * @var string
     */
    protected string $pkgPrefix = 'ladmin';

    /**
     * A mapping of layout component aliases to their corresponding class names.
     *
     * @var array<string, class-string>
     */
    protected array $layoutComponents = [
        'default-footer-content' => Layout\Footer\DefaultFooterContent::class,
        'footer' => Layout\Footer\Footer::class,
        'main-content' => Layout\MainContent\MainContent::class,
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

        // Declare the publishable resources of the package. Ensure publishable
        // resources are only available in console context.

        if ($this->app->runningInConsole()) {
            $this->setAssetsAsPublishable();
            $this->setConfigAsPublishable();
        }
    }

    /**
     * Register the package configuration.
     *
     * @return void
     */
    private function registerConfig(): void
    {
        // Register the main package configuration file.

        $this->mergeConfigFrom(
            $this->packagePath("config/{$this->pkgPrefix}.php"),
            $this->pkgPrefix
        );

        // Register the dedicated plugins configuration file.

        $this->mergeConfigFrom(
            $this->packagePath("config/{$this->pkgPrefix}_plugins.php"),
            "{$this->pkgPrefix}_plugins"
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
        $this->loadViewsFrom($path, $this->pkgPrefix);
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

        $this->loadViewComponentsAs($this->pkgPrefix, $components);
    }

    /**
     * Load the package translations.
     *
     * @return void
     */
    private function loadTranslations(): void
    {
        $path = $this->packagePath('lang');
        $this->loadTranslationsFrom($path, $this->pkgPrefix);
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
     * Declare the package configuration files as publishable resources.
     *
     * @return void
     */
    private function setConfigAsPublishable(): void
    {
        $mainCfg = $this->packagePath("config/{$this->pkgPrefix}.php");
        $pluginsCfg = $this->packagePath(
            "config/{$this->pkgPrefix}_plugins.php"
        );

        $this->publishes([
            $mainCfg => config_path("{$this->pkgPrefix}.php"),
            $pluginsCfg => config_path("{$this->pkgPrefix}_plugins.php"),
        ], 'config');
    }

    /**
     * Resolves the absolute path to a given relative package resource path.
     *
     * @param  string  $path  The relative path to the resource
     * @return string
     */
    private function packagePath(string $path): string
    {
        return __DIR__."/../{$path}";
    }
}
