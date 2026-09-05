<?php

namespace DFSmania\LaradminLte\Tests\Feature\Http\Controllers;

use App\Models\User;
use DFSmania\LaradminLte\Http\Controllers\UserProfileController;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\FortifyServiceProvider;

class UserProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Override the environment setup with extra configuration for these tests.
     *
     * @param  Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Call the parent method to ensure any additional environment setup is
        // performed.

        parent::defineEnvironment($app);

        // Set up the configuration to enable authentication scaffolding for
        // these tests.

        $app['config']->set('ladmin.auth.enabled', true);
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

    public function test_it_shows_the_authenticated_users_profile(): void
    {
        $user = $this->createUser();

        $view = (new UserProfileController)->show($this->requestFor($user));

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::profile.show', $view->getName());
        $this->assertSame($user, $view->getData()['user']);
    }

    public function test_it_returns_no_sessions_when_feature_disabled(): void
    {
        config(['ladmin.auth.features.browser_sessions' => false]);

        $sessions = (new ExposedUserProfileController)
            ->sessionsFor($this->requestFor($this->createUser()));

        $this->assertCount(0, $sessions);
    }

    public function test_it_returns_session_details_when_feature_enabled(): void
    {
        config([
            'ladmin.auth.features.browser_sessions' => true,
            'session.driver' => 'database',
        ]);

        $user = $this->createUser();
        $request = $this->requestFor($user);
        $currentSessionId = $request->session()->getId();

        DB::table('sessions')->insert([
            [
                'id' => $currentSessionId,
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0',
                'payload' => '',
                'last_activity' => now()->timestamp,
            ],
            [
                'id' => 'other-session',
                'user_id' => $user->id,
                'ip_address' => '192.0.2.1',
                'user_agent' => '',
                'payload' => '',
                'last_activity' => now()->subMinute()->timestamp,
            ],
        ]);

        $sessions = (new ExposedUserProfileController)->sessionsFor($request);

        $this->assertCount(2, $sessions);
        $this->assertTrue($sessions->first()->is_current_device);
        $this->assertSame('127.0.0.1', $sessions->first()->ip_address);
        $this->assertFalse($sessions->last()->is_current_device);
    }

    public function test_it_updates_a_profile_image(): void
    {
        Storage::fake('public');
        $user = $this->createUser();

        $response = $this->actingAs($user)->from('/user/profile')->put(
            '/user/profile_image',
            ['photo' => UploadedFile::fake()->image('profile.jpg')]
        );

        $response->assertRedirect('/user/profile');
        $response->assertSessionHas('status', 'profile-image-updated');

        Storage::disk('public')
            ->assertExists($user->fresh()->profile_image_path);
    }

    public function test_it_validates_profile_image_uploads(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->from('/user/profile')->put(
            '/user/profile_image',
            [
                'photo' => UploadedFile::fake()
                    ->create('document.txt', 1, 'text/plain'),
            ]
        );

        $response->assertRedirect('/user/profile');
        $response->assertSessionHasErrorsIn('updateProfileImage', ['photo']);
    }

    public function test_it_deletes_a_profile_image(): void
    {
        Storage::fake('public');
        $user = $this->createUser();
        $user->updateProfileImage(UploadedFile::fake()->image('profile.jpg'));
        $path = $user->fresh()->profile_image_path;

        $response = $this->actingAs($user)->from('/user/profile')
            ->delete('/user/profile_image');

        $response->assertRedirect('/user/profile');
        $response->assertSessionHas('status', 'profile-image-deleted');
        Storage::disk('public')->assertMissing($path);
    }

    public function test_it_rejects_account_deletion_on_invalid_password(): void
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->from('/user/profile')
            ->delete('/user', ['password' => 'incorrect-password']);

        $response->assertRedirect('/user/profile');
        $response->assertSessionHasErrorsIn('deleteAccount', ['password']);
        $this->assertNotNull($user->fresh());
    }

    public function test_it_deletes_an_account_after_validating_password(): void
    {
        Storage::fake('public');
        $user = $this->createUser();
        $user->updateProfileImage(UploadedFile::fake()->image('profile.jpg'));
        $path = $user->fresh()->profile_image_path;

        $response = $this->actingAs($user)
            ->delete('/user', ['password' => 'password']);

        $response->assertRedirect('/login');
        $response->assertSessionHas('status');
        $this->assertNull(User::find($user->id));
        Storage::disk('public')->assertMissing($path);
    }

    public function test_it_returns_not_found_when_logging_out_other_sessions_is_unavailable(): void
    {
        config(['ladmin.auth.features.browser_sessions' => false]);
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->delete('/user/sessions', ['password' => 'password']);

        $response->assertNotFound();
    }

    public function test_it_rejects_an_invalid_password_when_logging_out_other_sessions(): void
    {
        config(['session.driver' => 'database']);
        $user = $this->createUser();

        $response = $this->actingAs($user)->from('/user/profile')
            ->delete('/user/sessions', ['password' => 'incorrect-password']);

        $response->assertRedirect('/user/profile');
        $response->assertSessionHasErrorsIn('logoutOtherSessions', ['password']);
    }

    public function test_it_logs_out_other_browser_sessions(): void
    {
        config(['session.driver' => 'database']);
        $user = $this->createUser();
        $this->actingAs($user);
        $request = $this->requestFor($user, ['password' => 'password']);
        $currentSessionId = $request->session()->getId();

        DB::table('sessions')->insert([
            [
                'id' => $currentSessionId,
                'user_id' => $user->id,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0',
                'payload' => '',
                'last_activity' => now()->timestamp,
            ],
            [
                'id' => 'other-session',
                'user_id' => $user->id,
                'ip_address' => '192.0.2.1',
                'user_agent' => 'Mozilla/5.0',
                'payload' => '',
                'last_activity' => now()->subMinute()->timestamp,
            ],
        ]);

        $response = (new UserProfileController)->logoutOtherSessions($request);

        $this->assertTrue($response->isRedirect());
        $this->assertDatabaseHas('sessions', ['id' => $currentSessionId]);
        $this->assertDatabaseMissing('sessions', ['id' => 'other-session']);
        $this->assertSame(
            $user->getAuthPassword(),
            $request->session()->get('password_hash_web')
        );
    }

    /**
     * Create a new user for testing purposes.
     *
     * @return User
     */
    private function createUser(): User
    {
        return User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * Create a new user profile request for the given user and input data.
     *
     * @param  User  $user
     * @param  array  $input
     * @return Request
     */
    private function requestFor(User $user, array $input = []): Request
    {
        $session = $this->app['session']->driver();
        $session->start();

        $request = Request::create('/user/profile', 'GET', $input);
        $request->setLaravelSession($session);
        $request->setUserResolver(fn () => $user);

        return $request;
    }
}

/*
 * A subclass of the UserProfileController that exposes the getSessions method
 * for testing purposes, since getSessions is a protected method and cannot be
 * called directly from the test case.
 */
class ExposedUserProfileController extends UserProfileController
{
    /**
     * Get the sessions for the authenticated user.
     *
     * @return Collection<int, object>
     */
    public function sessionsFor(Request $request): Collection
    {
        return $this->getSessions($request);
    }
}
