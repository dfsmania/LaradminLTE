<?php

namespace DFSmania\LaradminLte\Tests\Unit\Actions\Auth;

use DFSmania\LaradminLte\Actions\Auth\HasValidationRules;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Validation\Rules\Password;

class HasValidationRulesTest extends TestCase
{
    public function test_it_returns_the_username_rules(): void
    {
        $rules = (new ValidationRulesConsumer)->getUsernameRules();

        $this->assertSame(['required', 'string', 'max:255'], $rules);
    }

    public function test_it_returns_email_rules_without_an_ignored_user(): void
    {
        $rules = (new ValidationRulesConsumer)->getEmailRules();

        $this->assertSame(
            ['required', 'string', 'email', 'max:255'],
            array_slice($rules, 0, 4)
        );

        $this->assertStringContainsString(
            'unique:users,NULL',
            (string) $rules[4]
        );
    }

    public function test_it_returns_email_rules_with_an_ignored_user(): void
    {
        $rules = (new ValidationRulesConsumer)->getEmailRules(42);

        $this->assertStringContainsString('42', (string) $rules[4]);
    }

    public function test_it_returns_password_rules_without_confirmation(): void
    {
        $rules = (new ValidationRulesConsumer)->getPasswordRules();

        $this->assertSame(['required', 'string'], array_slice($rules, 0, 2));
        $this->assertInstanceOf(Password::class, $rules[2]);
        $this->assertNotContains('confirmed', $rules);
    }

    public function test_it_returns_password_rules_with_confirmation(): void
    {
        $rules = (new ValidationRulesConsumer)->getPasswordRules(true);

        $this->assertContains('confirmed', $rules);
    }

    public function test_it_returns_current_password_rules(): void
    {
        $rules = (new ValidationRulesConsumer)->getCurrentPasswordRules();

        $this->assertSame(
            ['required', 'string', 'current_password:web'],
            $rules
        );
    }
}

/**
 * A simple class that uses the HasValidationRules trait for testing purposes.
 */
class ValidationRulesConsumer
{
    use HasValidationRules;

    /**
     * @return array<int, mixed>
     */
    public function getUsernameRules(): array
    {
        return $this->usernameRules();
    }

    /**
     * @return array<int, mixed>
     */
    public function getEmailRules(?int $ignoreUniqueForId = null): array
    {
        return $this->emailRules($ignoreUniqueForId);
    }

    /**
     * @return array<int, mixed>
     */
    public function getPasswordRules(bool $confirmed = false): array
    {
        return $this->passwordRules($confirmed);
    }

    /**
     * @return array<int, mixed>
     */
    public function getCurrentPasswordRules(): array
    {
        return $this->currentPasswordRules();
    }
}
