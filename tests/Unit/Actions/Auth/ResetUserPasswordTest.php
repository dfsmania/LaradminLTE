<?php

namespace DFSmania\LaradminLte\Tests\Unit\Actions\Auth;

use App\Models\User;
use DFSmania\LaradminLte\Actions\Auth\ResetUserPassword;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetUserPasswordTest extends TestCase
{
    use RefreshDatabase;

    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_resets_a_users_password(): void
    {
        $user = $this->createUser();

        (new ResetUserPassword)->reset($user, [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $this->assertTrue(
            Hash::check('new-password', $user->fresh()->password)
        );
    }

    public function test_it_rejects_a_non_matching_password_confirmation(): void
    {
        $user = $this->createUser();

        $this->expectException(ValidationException::class);

        (new ResetUserPassword)->reset($user, [
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ]);
    }

    // ------------------------------------------------------------------------
    // HELPER METHODS
    // ------------------------------------------------------------------------

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
}
