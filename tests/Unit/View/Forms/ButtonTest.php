<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\Button;
use Illuminate\View\View;

class ButtonTest extends TestCase
{
    public function test_it_sets_defaults_when_arguments_are_omitted(): void
    {
        $button = new Button;

        $this->assertNull($button->label);
        $this->assertNull($button->icon);
        $this->assertStringContainsString(
            'btn btn-secondary',
            $button->buttonClasses
        );
    }

    public function test_it_decodes_html_entities_in_the_label(): void
    {
        $button = new Button(label: 'Save &amp; close');

        $this->assertSame('Save & close', $button->label);
    }

    public function test_it_sets_the_icon(): void
    {
        $button = new Button(icon: 'fas fa-plus');

        $this->assertSame('fas fa-plus', $button->icon);
    }

    public function test_it_builds_classes_for_the_given_theme(): void
    {
        $button = new Button(theme: 'primary');

        $this->assertStringContainsString(
            'btn btn-primary',
            $button->buttonClasses
        );
    }

    public function test_it_ignores_invalid_sizing_values(): void
    {
        $button = new Button(sizing: 'invalid');

        $this->assertStringNotContainsString(
            'btn-invalid',
            $button->buttonClasses
        );
    }

    public function test_it_adds_a_size_modifier_class_for_valid_sizing(): void
    {
        $button = new Button(sizing: 'lg');

        $this->assertStringContainsString('btn-lg', $button->buttonClasses);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Button)->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::forms.button', $view->getName());
    }
}
