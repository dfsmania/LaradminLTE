<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\Checkbox;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;

class CheckboxTest extends TestCase
{
    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_sets_defaults_when_arguments_are_omitted(): void
    {
        $checkbox = new Checkbox('accept_terms');

        $this->assertSame('accept_terms', $checkbox->name);
        $this->assertSame('primary', $checkbox->theme);
        $this->assertFalse($checkbox->isSwitch);
        $this->assertNull($checkbox->label);
        $this->assertNull($checkbox->checkboxStyle);

        $this->assertStringContainsString(
            'form-check-label',
            $checkbox->labelClasses
        );
    }

    public function test_it_decodes_html_entities_in_the_label(): void
    {
        $checkbox = new Checkbox('accept_terms', label: 'I &amp; agree');

        $this->assertSame('I & agree', $checkbox->label);
    }

    public function test_it_adds_custom_label_classes(): void
    {
        $checkbox = new Checkbox('accept_terms', labelClasses: 'extra-class');

        $this->assertStringContainsString(
            'extra-class',
            $checkbox->labelClasses
        );
    }

    public function test_it_adjusts_label_margin_on_switch_mode(): void
    {
        $checkbox = new Checkbox('accept_terms', switchMode: true);

        $this->assertStringContainsString(
            'form-check-label',
            $checkbox->labelClasses
        );

        $this->assertStringContainsString('ms-1', $checkbox->labelClasses);
    }

    public function test_it_skips_margin_on_switch_for_small_sizing(): void
    {
        $checkbox = new Checkbox(
            'accept_terms',
            sizing: 'sm',
            switchMode: true
        );

        $this->assertStringContainsString(
            'form-check-label',
            $checkbox->labelClasses
        );

        $this->assertStringNotContainsString('ms-1', $checkbox->labelClasses);
    }

    public function test_it_adjusts_margin_on_checkbox_for_large_sizing(): void
    {
        $checkbox = new Checkbox('accept_terms', sizing: 'lg');

        $this->assertStringContainsString('ms-1', $checkbox->labelClasses);
    }

    public function test_it_adjusts_margin_on_switch_for_large_sizing(): void
    {
        $checkbox = new Checkbox(
            'accept_terms',
            sizing: 'lg',
            switchMode: true
        );

        $this->assertStringContainsString('ms-3', $checkbox->labelClasses);
    }

    public function test_it_resolves_styles_for_small_sizing(): void
    {
        $checkbox = new Checkbox('accept_terms', sizing: 'sm');

        $this->assertSame(
            'transform:scale(0.85);margin-left:-1.6em;',
            $checkbox->checkboxStyle
        );
    }

    public function test_it_resolves_styles_for_small_sizing_switch(): void
    {
        $checkbox = new Checkbox(
            'accept_terms',
            sizing: 'sm',
            switchMode: true
        );

        $this->assertSame(
            'transform:scale(0.85);margin-left:-2.6em;',
            $checkbox->checkboxStyle
        );
    }

    public function test_it_resolves_styles_for_large_sizing(): void
    {
        $checkbox = new Checkbox('accept_terms', sizing: 'lg');

        $this->assertSame(
            'transform:scale(1.3);margin-left:-1.4em;',
            $checkbox->checkboxStyle
        );
    }

    public function test_it_resolves_styles_for_large_sizing_switch(): void
    {
        $checkbox = new Checkbox(
            'accept_terms',
            sizing: 'lg',
            switchMode: true
        );

        $this->assertSame(
            'transform:scale(1.3);margin-left:-2.1em;',
            $checkbox->checkboxStyle
        );
    }

    public function test_it_has_no_inline_styles_for_invalid_sizing(): void
    {
        $checkbox = new Checkbox('accept_terms', sizing: 'invalid');

        $this->assertNull($checkbox->checkboxStyle);
    }

    public function test_it_is_checked_based_on_the_checked_attribute(): void
    {
        $checkbox = new Checkbox('accept_terms');
        $checkbox->withAttributes(['checked' => true]);

        $this->assertTrue($checkbox->isChecked(new ViewErrorBag));
    }

    public function test_it_is_not_checked_on_missing_checked_attribute(): void
    {
        $checkbox = new Checkbox('accept_terms');
        $checkbox->withAttributes([]);

        $this->assertFalse($checkbox->isChecked(new ViewErrorBag));
    }

    public function test_it_uses_old_input_for_checked_state_on_errors(): void
    {
        $this->flashOldInput(['accept_terms' => '1']);

        $checkbox = new Checkbox('accept_terms');
        $checkbox->withAttributes([]);

        $errors = (new ViewErrorBag)->put(
            'default',
            new MessageBag(['other_field' => 'Invalid.'])
        );

        $this->assertTrue($checkbox->isChecked($errors));
    }

    public function test_it_is_not_checked_if_no_old_input_on_errors(): void
    {
        $checkbox = new Checkbox('accept_terms');
        $checkbox->withAttributes(['checked' => true]);

        $errors = (new ViewErrorBag)->put(
            'default',
            new MessageBag(['other_field' => 'Invalid.'])
        );

        $this->assertFalse($checkbox->isChecked($errors));
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Checkbox('accept_terms'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::forms.checkbox', $view->getName());
    }

    // ------------------------------------------------------------------------
    // HELPER METHODS
    // ------------------------------------------------------------------------

    /**
     * Flash old input to the session.
     *
     * @param  array  $data
     * @return void
     */
    private function flashOldInput(array $data): void
    {
        $session = $this->app['session']->driver();
        $session->start();
        $session->flash('_old_input', $data);

        $this->app['request']->setLaravelSession($session);
    }
}
