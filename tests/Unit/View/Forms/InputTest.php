<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\Input;
use Illuminate\View\View;

class InputTest extends TestCase
{
    public function test_it_sets_up_the_input_base_properties(): void
    {
        $input = new Input('username');

        $this->assertSame('username', $input->name);
        $this->assertSame('username', $input->id);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Input('username'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::forms.input', $view->getName());
    }
}
