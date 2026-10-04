<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\Select;
use Illuminate\View\View;

class SelectTest extends TestCase
{
    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_filters_out_invalid_options(): void
    {
        $select = new Select('country', options: [
            ['label' => 'Missing value'],
            ['value' => 123],
            ['value' => 'us', 'label' => 'United States'],
        ]);

        $this->assertCount(1, $select->options);
        $this->assertSame('us', $select->options[0]['value']);
    }

    public function test_it_defaults_the_label_to_the_value_when_missing(): void
    {
        $select = new Select('country', options: [
            ['value' => 'us'],
        ]);

        $this->assertSame('us', $select->options[0]['label']);
    }

    public function test_it_marks_options_as_disabled(): void
    {
        $select = new Select('country', options: [
            ['value' => 'us', 'disabled' => true],
        ]);

        $this->assertTrue($select->options[0]['disabled']);
    }

    public function test_it_uses_the_selected_flag_when_no_errors(): void
    {
        $select = new Select('country', options: [
            ['value' => 'us', 'selected' => true],
            ['value' => 'ca'],
        ]);

        $this->assertTrue($select->options[0]['selected']);
        $this->assertFalse($select->options[1]['selected']);
    }

    public function test_it_uses_old_input_for_selected_state_on_errors(): void
    {
        $this->flashSessionErrors();
        $this->flashOldInput(['country' => 'ca']);

        $select = new Select('country', options: [
            ['value' => 'us', 'selected' => true],
            ['value' => 'ca'],
        ]);

        $this->assertFalse($select->options[0]['selected']);
        $this->assertTrue($select->options[1]['selected']);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Select('country'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::forms.select', $view->getName());
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

    /**
     * Flash session errors to the session.
     *
     * @return void
     */
    private function flashSessionErrors(): void
    {
        $session = $this->app['session']->driver();
        $session->start();
        $session->put('errors', true);
    }
}
