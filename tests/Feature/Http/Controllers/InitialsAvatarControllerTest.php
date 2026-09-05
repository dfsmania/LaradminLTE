<?php

namespace DFSmania\LaradminLte\Tests\Feature\Http\Controllers;

use DFSmania\LaradminLte\Tests\TestCase;

class InitialsAvatarControllerTest extends TestCase
{
    protected function defineEnvironment($app)
    {
        // Call the parent method to ensure any additional environment setup is
        // performed.

        parent::defineEnvironment($app);

        // Set up the configuration to enable authentication scaffolding for
        // these tests.

        $app['config']->set('ladmin.auth.enabled', true);
    }

    public function test_it_returns_a_svg_with_the_computed_initials(): void
    {
        $response = $this->get('/ladmin/avatar/initials?name=John+Doe');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/svg+xml');
        $response->assertSee('JD', false);
    }

    public function test_it_requires_the_name_parameter(): void
    {
        $response = $this->getJson('/ladmin/avatar/initials');

        $response->assertStatus(422);
    }
}
