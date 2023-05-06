<?php

namespace DFSmania\LaraliveAdmin;

use DFSmania\LaraliveAdmin\View\Components\Layout;
use Illuminate\Support\ServiceProvider;

class LaraliveAdminServiceProvider extends ServiceProvider
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
        'navbar' => Layout\Navbar\Navbar::class,
        'navbar-link' => Layout\Navbar\Link::class,
        'panel' => Layout\AdminPanel::class,
        'sidebar' => Layout\Sidebar\Sidebar::class,
        'sidebar-brand' => Layout\Sidebar\BrandLink::class,
        'sidebar-header' => Layout\Sidebar\Header::class,
        'sidebar-link' => Layout\Sidebar\Link::class,
    ];

    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap the package services.
     *
     * @return void
     */
    public function boot()
    {
        // Load the views of the package.

        $this->loadViews();

        // Load the blade components of the package.

        $this->loadComponents();

        // Declare the publishable resources of the package. This section is
        // only valid if the Laravel app is running on console.

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->setAssetsAsPublishable();
    }

    /**
     * Load the package views.
     *
     * @return void
     */
    private function loadViews()
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
    private function loadComponents()
    {
        // Load all the blade-x components.

        $components = array_merge(
            $this->layoutComponents,
        );

        $this->loadViewComponentsAs($this->prefix, $components);
    }

    /**
     * Declare the package assets as a publishable resource.
     *
     * @return void
     */
    private function setAssetsAsPublishable()
    {
        $path = $this->packagePath('resources/assets');

        $this->publishes([
            $path => public_path('vendor/laralive-admin'),
        ], 'assets');
    }

    /**
     * Get the absolute path to some package resource.
     *
     * @param  string  $path  The relative path to the resource
     * @return string
     */
    private function packagePath($path)
    {
        return __DIR__."/../{$path}";
    }
}
