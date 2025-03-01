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
    public function setUp(): void
    {
        parent::setUp();

        // Additional setup...
    }

    /**
     * Get the service providers of our package.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            LaradminLteServiceProvider::class,
        ];
    }

    /**
     * Make common environment setup, to be applied before running each test.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp(Application $app): void
    {
        // Perform environment setup...
    }
}
