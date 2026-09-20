<?php

namespace DFSmania\LaradminLte\Tests\Feature\Http\Controllers;

use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Foundation\Application;

class InitialsAvatarControllerFeatureDisabledTest extends TestCase
{
    /**
     * Override the environment setup with extra configuration for these tests.
     *
     * @param  Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Call the parent method to ensure base environment setup is performed.

        parent::defineEnvironment($app);

        // Set up the configuration to enable authentication scaffolding for
        // these tests.

        $app['config']->set('ladmin.auth.enabled', true);
        $app['config']->set('ladmin.auth.features.profile_image', false);
    }

    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_route_is_not_registered_when_feature_disabled(): void
    {
        $response = $this->get('/ladmin/avatar/initials?name=John+Doe');

        $response->assertNotFound();
    }
}
