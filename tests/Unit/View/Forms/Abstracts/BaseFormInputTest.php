<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms\Abstracts;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\Abstracts\BaseFormInput;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;

class BaseFormInputTest extends TestCase
{
    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_sets_defaults_when_arguments_are_omitted(): void
    {
        $input = new StubFormInput('username');

        $this->assertSame('username', $input->name);
        $this->assertSame('username', $input->id);
        $this->assertTrue($input->useOldInput);
        $this->assertTrue($input->useValidationFeedback);
        $this->assertSame('username', $input->errorKey);
        $this->assertNull($input->errorsBag);
    }

    public function test_it_accepts_custom_arguments(): void
    {
        $input = new StubFormInput(
            name: 'email',
            id: 'custom-id',
            noOldInput: true,
            noValidationFeedback: true,
            errorsBag: 'customBag'
        );

        $this->assertSame('email', $input->name);
        $this->assertSame('custom-id', $input->id);
        $this->assertFalse($input->useOldInput);
        $this->assertFalse($input->useValidationFeedback);
        $this->assertSame('customBag', $input->errorsBag);
    }

    public function test_it_ignores_invalid_sizing_values(): void
    {
        $input = new StubFormInput('username', sizing: 'invalid');

        $this->assertSame(
            'form-control disable-adminlte-validations shadow-none',
            $input->getBaseClasses($this->emptyErrors())
        );
    }

    public function test_it_adds_a_size_modifier_class_for_valid_sizing(): void
    {
        $input = new StubFormInput('username', sizing: 'sm');

        $this->assertStringContainsString(
            'form-control-sm',
            $input->getBaseClasses($this->emptyErrors())
        );
    }

    public function test_it_adds_invalid_class_when_field_has_error(): void
    {
        $input = new StubFormInput('username');

        $classes = $input->getBaseClasses($this->errorsFor('username'));

        $this->assertStringContainsString('is-invalid', $classes);
    }

    public function test_it_adds_valid_class_if_other_fields_have_errors(): void
    {
        $input = new StubFormInput('username');

        $classes = $input->getBaseClasses($this->errorsFor('other_field'));

        $this->assertStringContainsString('is-valid', $classes);
    }

    public function test_it_skips_validation_classes_if_feedback_disabled(): void
    {
        $input = new StubFormInput('username', noValidationFeedback: true);

        $classes = $input->getBaseClasses($this->errorsFor('username'));

        $this->assertStringNotContainsString('is-invalid', $classes);
        $this->assertStringNotContainsString('is-valid', $classes);
    }

    public function test_it_renders_the_view_returned_by_the_child_class(): void
    {
        $input = new StubFormInput('username');

        $view = $input->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::forms.input', $view->getName());
    }

    // ------------------------------------------------------------------------
    // HELPER METHODS
    // ------------------------------------------------------------------------

    /**
     * Get an empty ViewErrorBag.
     *
     * @return ViewErrorBag
     */
    private function emptyErrors(): ViewErrorBag
    {
        return new ViewErrorBag;
    }

    /**
     * Get a ViewErrorBag containing an error for the given key.
     *
     * @param  string  $key
     * @return ViewErrorBag
     */
    private function errorsFor(string $key): ViewErrorBag
    {
        $bag = new MessageBag([$key => 'The field is invalid.']);

        return (new ViewErrorBag)->put('default', $bag);
    }
}

/*
 * A concrete stub of the abstract BaseFormInput, needed since the class under
 * test cannot be instantiated directly.
 */
class StubFormInput extends BaseFormInput
{
    /**
     * Get the view name for the input.
     *
     * @return string
     */
    protected function viewName(): string
    {
        return 'ladmin::forms.input';
    }
}
