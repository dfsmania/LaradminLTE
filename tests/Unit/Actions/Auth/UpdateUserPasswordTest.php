<?php

namespace DFSmania\LaradminLte\Tests\Unit\Actions\Auth;

use App\Models\User;
use DFSmania\LaradminLte\Actions\Auth\UpdateUserPassword;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdateUserPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_password_when_current_password_valid(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        (new UpdateUserPassword)->update($user, [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $this->assertTrue(
            Hash::check('new-password', $user->fresh()->password)
        );
    }

    public function test_it_rejects_an_invalid_current_password(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        try {
            (new UpdateUserPassword)->update($user, [
                'current_password' => 'incorrect-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

            $this->fail('Expected the current password validation to fail.');
        } catch (ValidationException $exception) {
            $this->assertSame('updatePassword', $exception->errorBag);
            $this->assertArrayHasKey('current_password', $exception->errors());
        }

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    private function createUser(): User
    {
        return User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
