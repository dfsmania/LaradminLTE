<?php

namespace DFSmania\LaradminLte\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use HasValidationRules;

    /**
     * Validate and create a newly registered user. Returns the created user
     * instance.
     *
     * @param  array<string, string>  $input
     * @return User
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        // Validate the input data for creating a new user. If validation
        // fails, a ValidationException will be thrown with the appropriate
        // error messages.

        Validator::make($input, [
            'name' => $this->usernameRules(),
            'email' => $this->emailRules(),
            'password' => $this->passwordRules(confirmed: true),
        ])->validate();

        // Create and return the new user instance with the validated input
        // data.

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
