<?php

namespace DFSmania\LaradminLte\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use HasValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  User  $user
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function reset(User $user, array $input): void
    {
        // Validate the input data for resetting the user's password. If
        // validation fails, a ValidationException will be thrown with the
        // appropriate error messages.

        Validator::make($input, [
            'password' => $this->passwordRules(confirmed: true),
        ])->validate();

        // Reset the user's password with the new password provided in the
        // input data.

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
