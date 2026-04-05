<?php

namespace DFSmania\LaradminLte\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use HasValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  User  $user
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function update(User $user, array $input): void
    {
        // Validate the input data for updating the user's password. If
        // validation fails, a ValidationException will be thrown with the
        // appropriate error messages.

        Validator::make($input, [
            'current_password' => $this->currentPasswordRules(),
            'password' => $this->passwordRules(confirmed: true),
        ])->validateWithBag('updatePassword');

        // Update the user's password with the new password provided in the
        // input data.

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
