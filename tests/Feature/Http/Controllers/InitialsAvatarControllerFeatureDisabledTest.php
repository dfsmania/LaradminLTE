<?php

namespace DFSmania\LaradminLte\Tests\Feature\Http\Controllers;

use DFSmania\LaradminLte\Tests\TestCase;

class InitialsAvatarControllerFeatureDisabledTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('ladmin.auth.features.profile_image', false);
    }

    public function test_route_is_not_registered_when_feature_disabled(): void
    {
        $response = $this->get('/ladmin/avatar/initials?name=John+Doe');

        $response->assertNotFound();
    }
}
