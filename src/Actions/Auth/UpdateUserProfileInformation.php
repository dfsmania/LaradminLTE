<?php

namespace DFSmania\LaradminLte\Actions\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    use HasValidationRules;

    /**
     * Validate and update the given user's profile information.
     *
     * @param  User  $user
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function update(User $user, array $input): void
    {
        // Validate the input data for updating the user's profile information.
        // If validation fails, a ValidationException will be thrown with the
        // appropriate error messages.

        Validator::make($input, [
            'name' => $this->usernameRules(),
            'email' => $this->emailRules(ignoreUniqueForId: $user->id),
        ])->validateWithBag('updateProfileInformation');

        // Determine if the email address has changed and if the user should be
        // sent an email verification notification.

        $newEmail = strtolower(trim($input['email']));

        $requireEmailVerification = $newEmail !== $user->email
            && $user instanceof MustVerifyEmail;

        // Collect the new data for updating the user's profile information.
        // If email verification is required, clear the email_verified_at field.

        $newData = [
            'name' => $input['name'],
            'email' => $newEmail,
        ];

        if ($requireEmailVerification) {
            $newData['email_verified_at'] = null;
        }

        // Update the user's profile information with the new data. If email
        // verification is required, we also send the email verification
        // notification to the user.

        $user->forceFill($newData)->save();

        if ($requireEmailVerification) {
            $user->sendEmailVerificationNotification();
        }
    }
}
