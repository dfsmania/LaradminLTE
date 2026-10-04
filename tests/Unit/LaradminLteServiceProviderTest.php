<?php

namespace DFSmania\LaradminLte\Tests\Unit;

use DFSmania\LaradminLte\LaradminLteServiceProvider;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Laravel\Fortify\Contracts\ConfirmPasswordViewResponse;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse;
use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\FortifyServiceProvider;
use ReflectionMethod;

class LaradminLteServiceProviderTest extends TestCase
{
    /**
     * Override the environment setup with extra configuration for these tests.
     *
     * @param  Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        parent::defineEnvironment($app);

        $app['config']->set('ladmin.auth.enabled', true);
        $app['config']->set('ladmin.auth.home_path', '/after-auth');
        $app['config']->set('ladmin.auth.features.registration', true);
        $app['config']->set('ladmin.auth.features.password_reset', true);
        $app['config']->set('ladmin.auth.features.email_verification', true);

        $app['config']->set(
            'ladmin.auth.features.update_profile_information',
            true
        );

        $app['config']->set('ladmin.auth.features.update_passwords', true);
    }

    /**
     * Override the package providers to include Fortify for these tests.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FortifyServiceProvider::class,
            ...parent::getPackageProviders($app),
        ];
    }

    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_registers_the_fortify_features_and_views(): void
    {
        $expectedFeatures = [
            Features::registration(),
            Features::resetPasswords(),
            Features::emailVerification(),
            Features::updateProfileInformation(),
            Features::updatePasswords(),
        ];

        $this->assertSame($expectedFeatures, config('fortify.features'));
        $this->assertSame('/after-auth', config('fortify.home'));
        $this->assertTrue(Fortify::$registersRoutes);

        $request = Request::create('/test');

        $views = [
            LoginViewResponse::class => 'ladmin::auth.login',
            ConfirmPasswordViewResponse::class => 'ladmin::auth.confirm-password',
            RegisterViewResponse::class => 'ladmin::auth.register',
            RequestPasswordResetLinkViewResponse::class => 'ladmin::auth.forgot-password',
            VerifyEmailViewResponse::class => 'ladmin::auth.verify-email',
        ];

        foreach ($views as $responseClass => $viewName) {
            $response = app($responseClass)->toResponse($request);

            $this->assertInstanceOf(View::class, $response);
            $this->assertSame($viewName, $response->getName());
        }

        $resetResponse = app(ResetPasswordViewResponse::class)
            ->toResponse($request);

        $this->assertInstanceOf(View::class, $resetResponse);

        $this->assertSame(
            'ladmin::auth.reset-password',
            $resetResponse->getName()
        );

        $this->assertSame($request, $resetResponse->getData()['request']);
    }

    public function test_it_compiles_the_package_plugin_directive(): void
    {
        $compiled = Blade::compileString('@ladmin_plugin("charts")');

        $this->assertStringContainsString(
            'PluginsManager::setPluginAsRequired("charts")',
            $compiled
        );
    }

    public function test_it_validates_translatable_values(): void
    {
        $cases = [
            ['a string', true],
            [['English'], true],
            [['English', ['key' => 'value']], true],
            [[], false],
            [[0 => 123], false],
            [['English', 'invalid options'], false],
        ];

        foreach ($cases as [$value, $expected]) {
            $validator = Validator::make(
                ['label' => $value],
                ['label' => 'ladmin_translatable']
            );

            $this->assertSame($expected, $validator->passes());
        }
    }

    public function test_it_skips_fortify_route_management_when_disabled(): void
    {
        $provider = new LaradminLteServiceProvider($this->app);
        $originalValue = Fortify::$registersRoutes;

        config([
            'ladmin.auth.enabled' => false,
            'ladmin.auth.manages_fortify_routes' => true,
        ]);

        try {
            Fortify::$registersRoutes = true;
            $this->invokePrivateMethod($provider, 'setupFortify');

            $this->assertFalse(Fortify::$registersRoutes);

            config(['ladmin.auth.manages_fortify_routes' => false]);
            Fortify::$registersRoutes = true;

            $this->invokePrivateMethod($provider, 'setupFortify');

            $this->assertTrue(Fortify::$registersRoutes);
        } finally {
            Fortify::$registersRoutes = $originalValue;
        }
    }

    /**
     * Helper method to invoke private methods for testing purposes.
     */
    private function invokePrivateMethod(object $target, string $method): void
    {
        $reflection = new ReflectionMethod($target, $method);
        $reflection->invoke($target);
    }
}
