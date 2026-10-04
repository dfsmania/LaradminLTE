<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms\Concerns;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\Concerns\HandlesOldInput;

class HandlesOldInputTest extends TestCase
{
    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_old_input_support_is_enabled_by_default(): void
    {
        $stub = new StubWithOldInput;

        $this->assertTrue($stub->useOldInput);
    }

    public function test_it_returns_default_value_when_no_old_input(): void
    {
        $stub = new StubWithOldInput;

        $this->assertSame('default', $stub->resolveOldInput('name', 'default'));
    }

    public function test_it_returns_the_old_input_value_when_available(): void
    {
        $this->flashOldInput(['name' => 'Jane Doe']);

        $stub = new StubWithOldInput;

        $this->assertSame(
            'Jane Doe',
            $stub->resolveOldInput('name', 'default')
        );
    }

    public function test_it_ignores_old_input_when_support_is_disabled(): void
    {
        $this->flashOldInput(['name' => 'Jane Doe']);

        $stub = new StubWithOldInput;
        $stub->useOldInput = false;

        $this->assertSame('default', $stub->resolveOldInput('name', 'default'));
    }

    // ------------------------------------------------------------------------
    // HELPER METHODS
    // ------------------------------------------------------------------------

    /**
     * Flash the given data as old input, so it becomes available through the
     * global "old()" helper.
     *
     * @param  array  $data
     * @return void
     */
    private function flashOldInput(array $data): void
    {
        $session = $this->app['session']->driver();
        $session->start();
        $session->flash('_old_input', $data);

        $this->app['request']->setLaravelSession($session);
    }
}

/*
 * A concrete stub using the HandlesOldInput trait, needed since the trait
 * cannot be tested directly.
 */
class StubWithOldInput
{
    use HandlesOldInput;
}
