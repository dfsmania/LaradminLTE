<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Avatars;

use DFSmania\LaradminLte\Support\Avatars\InitialsAvatarGenerator;
use DFSmania\LaradminLte\Tests\TestCase;

class InitialsAvatarGeneratorTest extends TestCase
{
    public function test_it_computes_initials_from_multiple_words(): void
    {
        $generator = new InitialsAvatarGenerator('John Doe Smith');

        $this->assertSame('JS', $generator->getInitials());
    }

    public function test_it_computes_initials_from_two_words(): void
    {
        $generator = new InitialsAvatarGenerator('John Doe');

        $this->assertSame('JD', $generator->getInitials());
    }

    public function test_it_computes_initials_from_a_single_word(): void
    {
        $generator = new InitialsAvatarGenerator('John');

        $this->assertSame('JO', $generator->getInitials());
    }

    public function test_it_computes_empty_initials_from_empty_string(): void
    {
        $generator = new InitialsAvatarGenerator('');

        $this->assertSame('', $generator->getInitials());
    }

    public function test_it_picks_a_deterministic_background_color(): void
    {
        $first = new InitialsAvatarGenerator('Jane Smith');
        $second = new InitialsAvatarGenerator('Jane Smith');

        $this->assertSame(
            $first->getBackgroundColor(),
            $second->getBackgroundColor()
        );
    }

    public function test_it_picks_colors_from_the_configured_palette(): void
    {
        $palette = ['#111111', '#222222'];

        $generator = new InitialsAvatarGenerator('Jane Smith', [
            'background_colors' => $palette,
        ]);

        $this->assertContains($generator->getBackgroundColor(), $palette);
    }

    public function test_it_generates_valid_svg_markup(): void
    {
        $generator = new InitialsAvatarGenerator('John Doe', ['size' => 64]);

        $svg = $generator->toSvg();

        $this->assertStringContainsString('<svg', $svg);
        $this->assertStringContainsString('JD', $svg);
        $this->assertStringContainsString('width="64"', $svg);
    }
}
