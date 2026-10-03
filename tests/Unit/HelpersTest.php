<?php

namespace DFSmania\LaradminLte\Tests\Unit;

use DFSmania\LaradminLte\LaradminLte;
use DFSmania\LaradminLte\Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_ladmin_returns_the_registered_singleton(): void
    {
        $resolved = $this->app->make(LaradminLte::class);

        $this->assertInstanceOf(LaradminLte::class, ladmin());
        $this->assertSame($resolved, ladmin());
    }

    public function test_it_can_be_included_after_composer_autoload(): void
    {
        $result = include dirname(__DIR__, 2).'/src/helpers.php';

        $this->assertSame(1, $result);
        $this->assertTrue(function_exists('ladmin'));
    }
}
