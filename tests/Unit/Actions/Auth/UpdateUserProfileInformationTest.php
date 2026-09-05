<?php

namespace DFSmania\LaradminLte\Tests\Unit\Actions\Auth;

use App\Models\User;
use App\Models\VerifiableUser;
use DFSmania\LaradminLte\Actions\Auth\UpdateUserProfileInformation;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class UpdateUserProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_users_profile_information(): void
    {
        $user = $this->createUser();

        (new UpdateUserProfileInformation)->update($user, [
            'name' => 'Jane Smith',
            'email' => 'JANE.SMITH@EXAMPLE.COM',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
        ]);
    }

    public function test_it_rejects_an_email_address_already_used(): void
    {
        $user = $this->createUser();

        User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->expectException(ValidationException::class);

        (new UpdateUserProfileInformation)->update($user, [
            'name' => 'Jane Doe',
            'email' => 'existing@example.com',
        ]);
    }

    public function test_it_requires_email_verification(): void
    {
        Notification::fake();
        $user = $this->createVerifiableUser();

        (new UpdateUserProfileInformation)->update($user, [
            'name' => 'Jane Smith',
            'email' => 'JANE.SMITH@EXAMPLE.COM',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'jane.smith@example.com',
            'email_verified_at' => null,
        ]);
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_not_send_verification_when_email_is_unchanged(): void
    {
        Notification::fake();
        $user = $this->createVerifiableUser();

        (new UpdateUserProfileInformation)->update($user, [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        Notification::assertNothingSent();
    }

    private function createUser(): User
    {
        return User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    private function createVerifiableUser(): VerifiableUser
    {
        $user = new VerifiableUser;
        $user->forceFill([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ])->save();

        return $user;
    }
}
