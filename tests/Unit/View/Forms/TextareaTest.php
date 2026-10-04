<?php

namespace DFSmania\LaradminLte\Tests\Unit\View\Forms;

use DFSmania\LaradminLte\Tests\TestCase;
use DFSmania\LaradminLte\View\Forms\Textarea;
use Illuminate\View\View;

class TextareaTest extends TestCase
{
    public function test_it_sets_up_the_input_base_properties(): void
    {
        $textarea = new Textarea('description');

        $this->assertSame('description', $textarea->name);
        $this->assertSame('description', $textarea->id);
    }

    public function test_it_renders_the_expected_view(): void
    {
        $view = (new Textarea('description'))->render();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('ladmin::forms.textarea', $view->getName());
    }
}
