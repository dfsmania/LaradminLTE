<?php

namespace DFSmania\LaradminLte\Tests\Unit\Actions\Auth;

use App\Models\User;
use DFSmania\LaradminLte\Actions\Auth\CreateNewUser;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CreateNewUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_user_with_a_hashed_password(): void
    {
        $user = (new CreateNewUser)->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_it_rejects_an_existing_email_address(): void
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->expectException(ValidationException::class);

        (new CreateNewUser)->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
    }

    public function test_it_requires_a_matching_password_confirmation(): void
    {
        $this->expectException(ValidationException::class);

        (new CreateNewUser)->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password',
            'password_confirmation' => 'different-password',
        ]);
    }
}
