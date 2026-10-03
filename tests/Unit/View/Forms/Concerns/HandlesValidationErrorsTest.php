<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms\Concerns;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\Concerns\HandlesValidationErrors;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use PHPUnit\Framework\Attributes\DataProvider;

class HandlesValidationErrorsTest extends TestCase
{
    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_initializes_the_error_key_and_errors_bag(): void
    {
        $stub = new StubWithValidationErrors('username', 'customBag');

        $this->assertSame('username', $stub->errorKey);
        $this->assertSame('customBag', $stub->errorsBag);
    }

    /**
     * Data provider for error key generation tests.
     *
     * @return array
     */
    public static function errorKeyProvider(): array
    {
        return [
            'plain name' => ['username', 'username'],
            'trailing empty brackets' => ['files[]', 'files'],
            'indexed brackets' => ['person[2][name]', 'person.2.name'],
            'nested empty brackets' => [
                'addresses[][street]',
                'addresses.*.street',
            ],
        ];
    }

    #[DataProvider('errorKeyProvider')]
    public function test_it_generates_the_error_key_from_the_field_name(
        string $name,
        string $expectedKey
    ): void {
        $stub = new StubWithValidationErrors($name);

        $this->assertSame($expectedKey, $stub->keyFor($name));
    }

    public function test_it_detects_an_error_for_the_configured_key(): void
    {
        $stub = new StubWithValidationErrors('username');

        $this->assertTrue($stub->hasError($this->errorsFor('username')));
        $this->assertFalse($stub->hasError($this->errorsFor('other_field')));
    }

    public function test_it_retrieves_the_first_error_message(): void
    {
        $stub = new StubWithValidationErrors('username');

        $this->assertSame(
            'The username field is invalid.',
            $stub->firstError($this->errorsFor('username'))
        );
    }

    public function test_it_detects_any_errors_in_the_bag(): void
    {
        $stub = new StubWithValidationErrors('username');

        $this->assertTrue($stub->anyErrors($this->errorsFor('other_field')));
        $this->assertFalse($stub->anyErrors(new ViewErrorBag));
    }

    public function test_it_uses_the_configured_errors_bag(): void
    {
        $stub = new StubWithValidationErrors('username', 'customBag');

        $bag = new MessageBag(['username' => 'Invalid username.']);
        $errors = (new ViewErrorBag)->put('customBag', $bag);

        $this->assertTrue($stub->hasError($errors));
    }

    public function test_it_fallsback_to_default_bag_if_none_configured(): void
    {
        $stub = new StubWithValidationErrors('username');

        $this->assertFalse($stub->hasError(new ViewErrorBag));
    }

    // ------------------------------------------------------------------------
    // HELPER METHODS
    // ------------------------------------------------------------------------

    /**
     * Get a ViewErrorBag containing an error for the given key.
     *
     * @param  string  $key
     * @return ViewErrorBag
     */
    private function errorsFor(string $key): ViewErrorBag
    {
        $bag = new MessageBag([$key => 'The username field is invalid.']);

        return (new ViewErrorBag)->put('default', $bag);
    }
}

/*
 * A concrete stub using the HandlesValidationErrors trait, needed since the
 * trait cannot be tested directly.
 */
class StubWithValidationErrors
{
    use HandlesValidationErrors;

    /**
     * Initialize the stub with the given error key and optional errors bag.
     *
     * @param  string  $name
     * @param  string|null  $errorsBag
     */
    public function __construct(string $name, ?string $errorsBag = null)
    {
        $this->initValidationErrors($name, $errorsBag);
    }

    /**
     * Get the error key for the given name.
     *
     * @param  string  $name
     * @return string
     */
    public function keyFor(string $name): string
    {
        return $this->getErrorKeyFromName($name);
    }
}
