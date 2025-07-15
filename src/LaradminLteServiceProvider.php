<?php

namespace DFSmania\LaradminLte;

use DFSmania\LaradminLte\View\Layout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
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
        'favicons' => Layout\Head\Favicons::class,
        'footer' => Layout\Footer\Footer::class,
        'main-content' => Layout\MainContent\MainContent::class,
        'navbar' => Layout\Navbar\Navbar::class,
        'panel' => Layout\AdminPanel::class,
        'sidebar' => Layout\Sidebar\Sidebar::class,
        'sidebar-brand' => Layout\Sidebar\BrandLink::class,
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

        // Bind a singleton instance of the main package class to ensure that
        // only one instance is created and shared throughout the application's
        // lifecycle within the same request-response cycle.

        $this->app->singleton(LaradminLte::class, function ($app) {
            return new LaradminLte;
        });
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

        // Load the custom blade directives of the package.

        $this->loadCustomBladeDirectives();

        // Load the custom validators of the package.

        $this->loadCustomValidators();

        // Declare the publishable resources of the package. Ensure publishable
        // resources are only available in console context.

        if ($this->app->runningInConsole()) {
            $this->setAssetsAsPublishable();
            $this->setConfigAsPublishable();
            $this->setTranslationsAsPublishable();
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

        // Register the dedicated menu configuration file.

        $this->mergeConfigFrom(
            $this->packagePath("config/{$this->pkgPrefix}_menu.php"),
            "{$this->pkgPrefix}_menu"
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
     * Load the custom blade directives of the package.
     *
     * @return void
     */
    private function loadCustomBladeDirectives(): void
    {
        // Register the "ladmin_plugin" directive to explicitly include plugin
        // resources in the HTML document.

        Blade::directive("{$this->pkgPrefix}_plugin", function ($pluginName) {
            $phpCode = "\DFSmania\LaradminLte\Tools\Plugins";
            $phpCode .= "\PluginsManager::setPluginAsRequired($pluginName);";

            return "<?php {$phpCode} ?>";
        });
    }

    /**
     * Load the custom validators of the package.
     *
     * @return void
     */
    private function loadCustomValidators(): void
    {
        // Register a custom validator for validating translatable values.
        // This validator checks if the value is a string or an array with a
        // string as the first element and an optional array as the second
        // element.

        $alias = "{$this->pkgPrefix}_translatable";

        Validator::extend($alias, function ($attribute, $value): bool {
            return is_string($value)
                || (is_array($value) && $this->isTranslatableArray($value));
        });
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
            $path => public_path("vendor/{$this->pkgPrefix}"),
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
        $menuCfg = $this->packagePath("config/{$this->pkgPrefix}_menu.php");
        $pluginsCfg = $this->packagePath(
            "config/{$this->pkgPrefix}_plugins.php"
        );

        $this->publishes([
            $mainCfg => config_path("{$this->pkgPrefix}.php"),
            $menuCfg => config_path("{$this->pkgPrefix}_menu.php"),
            $pluginsCfg => config_path("{$this->pkgPrefix}_plugins.php"),
        ], 'config');
    }

    /**
     * Declare the package translations files as a publishable resource.
     *
     * @return void
     */
    private function setTranslationsAsPublishable(): void
    {
        $path = $this->packagePath('lang');

        $this->publishes([
            $path => lang_path("vendor/{$this->pkgPrefix}"),
        ], 'translations');
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

    /**
     * Checks if the given array is a valid translatable array.
     *
     * A valid translatable array should have a string as the first element
     * and an optional array as the second element.
     *
     * @param  array  $arr  The array to check.
     * @return bool
     */
    private function isTranslatableArray(array $arr): bool
    {
        return isset($arr[0])
            && is_string($arr[0])
            && (! isset($arr[1]) || is_array($arr[1]));
    }
}
