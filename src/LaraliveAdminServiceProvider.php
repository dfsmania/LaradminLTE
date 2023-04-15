<?php

namespace DFSmania\LaraliveAdmin;

use Illuminate\Support\ServiceProvider;

class LaraliveAdminServiceProvider extends ServiceProvider
{
    /**
     * The prefix to use for register or load the package resources.
     *
     * @var string
     */
    protected $prefix = 'ladmin';

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
        // Load the package resources.

        $this->loadViews();

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
        // Load the layout views.
    }

    /**
     * Declare the package assets as a publishable resource.
     *
     * @return void
     */
    private function setAssetsAsPublishable()
    {
        //
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
