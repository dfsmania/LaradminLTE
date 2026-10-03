<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\InputGroup;
use Illuminate\View\View;

class InputGroupTest extends TestCase
{
    public function test_it_sets_defaults_when_arguments_are_omitted(): void
    {
        $group = new InputGroup('username');

        $this->assertSame('username', $group->inputName);
        $this->assertNull($group->label);
        $this->assertSame('mb-3', $group->formGroupClasses);
        $this->assertSame('form-label', $group->labelClasses);
        $this->assertSame('input-group', $group->inputGroupClasses);
        $this->assertTrue($group->useValidationFeedback);
        $this->assertNull($group->validFeedbackMessage);
        $this->assertFalse($group->floatingLabelMode);
        $this->assertSame('username', $group->errorKey);
    }

    public function test_it_decodes_html_entities_in_the_label(): void
    {
        $group = new InputGroup('username', label: 'Full &amp; name');

        $this->assertSame('Full & name', $group->label);
    }

    public function test_it_adds_custom_classes(): void
    {
        $group = new InputGroup(
            'username',
            labelClasses: 'extra-label',
            fgroupClasses: 'extra-group',
            igroupClasses: 'extra-input-group'
        );

        $this->assertStringContainsString('extra-label', $group->labelClasses);

        $this->assertStringContainsString(
            'extra-group',
            $group->formGroupClasses
        );

        $this->assertStringContainsString(
            'extra-input-group',
            $group->inputGroupClasses
        );
    }

    public function test_it_ignores_invalid_sizing_values(): void
    {
        $group = new InputGroup('username', sizing: 'invalid');

        $this->assertSame('input-group', $group->inputGroupClasses);
    }

    public function test_it_adds_a_size_modifier_class_for_valid_sizing(): void
    {
        $group = new InputGroup('username', sizing: 'sm');

        $this->assertSame(
            'input-group input-group-sm',
            $group->inputGroupClasses
        );
    }

    public function test_it_omits_the_form_label_class_in_floating_mode(): void
    {
        $group = new InputGroup('username', floatingLabel: true);

        $this->assertTrue($group->floatingLabelMode);
        $this->assertSame('', $group->labelClasses);
    }

    public function test_it_disables_validation_feedback(): void
    {
        $group = new InputGroup('username', noValidationFeedback: true);

        $this->assertFalse($group->useValidationFeedback);
    }

    public function test_it_sets_the_valid_feedback_message(): void
    {
        $group = new InputGroup(
            'username',
            validFeedbackMessage: 'Looks good!'
        );

        $this->assertSame('Looks good!', $group->validFeedbackMessage);
    }

    public function test_it_uses_the_configured_errors_bag(): void
    {
        $group = new InputGroup('username', errorsBag: 'customBag');

        $this->assertSame('customBag', $group->errorsBag);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new InputGroup('username'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::forms.input-group', $view->getName());
    }
}
