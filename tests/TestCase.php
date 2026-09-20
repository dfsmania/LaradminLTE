<?php

namespace DFSmania\LaradminLte\Tests;

use DFSmania\LaradminLte\LaradminLteServiceProvider;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * Make common test setup, to be applied before running each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Additional setup...
    }

    /**
     * Get the service providers of our package.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaradminLteServiceProvider::class,
        ];
    }

    /**
     * Define common environment setup, to be applied before running each test.
     *
     * @param  Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Set up the application key for testing, as some features may require
        // it.

        $app['config']->set(
            'app.key',
            'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA='
        );

        // Set up the database configuration for testing, using an in-memory
        // SQLite database.

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite.database', ':memory:');
    }

    /**
     * Define database migrations used by tests.
     * This is a hook provided by Orchestra Testbench to set up the database
     * schema for testing.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        // Load the default Laravel migrations for users, password resets, etc.

        $this->loadLaravelMigrations();
        $this->loadPackageMigrations();
    }

    /**
     * Define database migrations after the database is refreshed.
     * This is a hook provided by Orchestra Testbench to set up the database
     * schema for testing after the database has been refreshed.
     *
     * @return void
     */
    protected function defineDatabaseMigrationsAfterDatabaseRefreshed()
    {
        // Load the default Laravel migrations for users, password resets, etc.

        $this->loadLaravelMigrations();
        $this->loadPackageMigrations();
    }

    /**
     * Load the package's database migrations for testing.
     * This is a helper method to load the package's migrations into the
     * testing database.
     *
     * @return void
     */
    private function loadPackageMigrations(): void
    {
        $this->artisan('migrate', [
            '--path' => __DIR__.'/../database/migrations',
            '--realpath' => true,
        ]);
    }
}
