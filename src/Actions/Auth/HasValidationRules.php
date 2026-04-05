<?php

namespace DFSmania\LaradminLte\Actions\Auth;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\Rules\Password;

trait HasValidationRules
{
    /**
     * Get the validation rules used to validate user names.
     *
     * @return array<int, Rule|array<mixed>|string>
     */
    protected function usernameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate email addresses.
     *
     * @param  ?int  $ignoreUniqueForId  An optional user ID to ignore when
     *                                   checking for unique email addresses.
     * @return array<int, Rule|array<mixed>|string>
     */
    protected function emailRules(?int $ignoreUniqueForId = null): array
    {
        $uniqueRule = ValidationRule::unique(User::class);

        if (! is_null($ignoreUniqueForId)) {
            $uniqueRule->ignore($ignoreUniqueForId);
        }

        return ['required', 'string', 'email', 'max:255', $uniqueRule];
    }

    /**
     * Get the validation rules used to validate passwords.
     *
     * @param  bool  $confirmed  Whether the password should be confirmed.
     * @return array<int, Rule|array<mixed>|string>
     */
    protected function passwordRules(bool $confirmed = false): array
    {
        $rules = ['required', 'string', Password::default()];

        if ($confirmed) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }

    /**
     * Get the validation rules used to validate the current password.
     *
     * @return array<int, Rule|array<mixed>|string>
     */
    protected function currentPasswordRules(): array
    {
        return ['required', 'string', 'current_password:web'];
    }
}
