<?php

namespace DFSmania\LaradminLte\Tests\Unit\Models\Concerns;

use App\Models\User;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HasProfileImageTest extends TestCase
{
    use RefreshDatabase;

    protected function defineEnvironment($app)
    {
        // Call the parent method to ensure any additional environment setup is
        // performed.

        parent::defineEnvironment($app);

        // Set up the configuration to enable authentication scaffolding for
        // these tests.

        $app['config']->set('ladmin.auth.enabled', true);
    }

    public function test_it_stores_a_profile_image(): void
    {
        Storage::fake('public');
        $user = $this->createUser();

        $user->updateProfileImage(UploadedFile::fake()->image('profile.jpg'));

        $path = $user->fresh()->profile_image_path;

        $this->assertStringStartsWith('profile-images/', $path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_it_replaces_the_previous_profile_image(): void
    {
        Storage::fake('public');
        $user = $this->createUser();

        $user->updateProfileImage(UploadedFile::fake()->image('previous.jpg'));
        $previousPath = $user->fresh()->profile_image_path;

        $user->updateProfileImage(UploadedFile::fake()->image('new.jpg'));

        $replacementPath = $user->fresh()->profile_image_path;

        $this->assertNotSame($previousPath, $replacementPath);
        Storage::disk('public')->assertMissing($previousPath);
        Storage::disk('public')->assertExists($replacementPath);
    }

    public function test_it_deletes_a_profile_image(): void
    {
        Storage::fake('public');
        $user = $this->createUser();

        $user->updateProfileImage(UploadedFile::fake()->image('profile.jpg'));
        $path = $user->fresh()->profile_image_path;

        $user->fresh()->deleteProfileImage();

        Storage::disk('public')->assertMissing($path);
        $this->assertNull($user->fresh()->profile_image_path);
    }

    public function test_it_leaves_user_without_profile_image_unchanged(): void
    {
        $user = $this->createUser();

        $user->deleteProfileImage();

        $this->assertNull($user->fresh()->profile_image_path);
    }

    public function test_it_returns_stored_image_url_when_file_exists(): void
    {
        Storage::fake('public');
        $user = $this->createUser();

        $user->updateProfileImage(UploadedFile::fake()->image('profile.jpg'));
        $user = $user->fresh();

        $this->assertSame(
            Storage::disk('public')->url($user->profile_image_path),
            $user->profileImageUrl()
        );
    }

    public function test_it_returns_a_local_initials_avatar_url(): void
    {
        config(['ladmin.auth.profile_images.default_mode' => 'local_initials']);
        $user = $this->createUser();

        $this->assertSame(
            route('ladmin.avatar.initials', ['name' => 'Jane Doe']),
            $user->profileImageUrl()
        );
    }

    public function test_it_returns_a_ui_avatars_url_when_configured(): void
    {
        config(['ladmin.auth.profile_images.default_mode' => 'initials']);
        $user = $this->createUser('Jane Doe');

        $this->assertStringStartsWith(
            'https://ui-avatars.com/api/?name=Jane+Doe',
            $user->profileImageUrl()
        );
    }

    public function test_it_returns_a_gravatar_url_when_configured(): void
    {
        config(['ladmin.auth.profile_images.default_mode' => 'robohash']);
        $user = $this->createUser('Jane Doe', ' JANE@EXAMPLE.COM ');

        $this->assertStringStartsWith(
            'https://www.gravatar.com/avatar/'.md5('jane@example.com'),
            $user->profileImageUrl()
        );
    }

    private function createUser(
        string $name = 'Jane Doe',
        string $email = 'jane@example.com'
    ): User {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => 'password',
        ]);
    }
}
