<?php

namespace DFSmania\LaradminLte\Support\Avatars;

/**
 * Generates a local SVG avatar with a user's initials, without relying on any
 * external service. This is useful for environments without an internet
 * connection.
 */
class InitialsAvatarGenerator
{
    /**
     * The default size (width and height, in pixels) of the generated SVG
     * avatar.
     */
    private const DEFAULT_SIZE = 128;

    /**
     * The default color used for the initials text.
     */
    private const DEFAULT_FOREGROUND_COLOR = '#FFFFFF';

    /**
     * The default palette of background colors to choose from.
     */
    private const DEFAULT_BACKGROUND_COLORS = [
        '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5',
        '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50',
        '#8BC34A', '#FF9800', '#FF5722', '#795548', '#607D8B',
    ];

    /**
     * The name used to compute the initials and the background color.
     *
     * @var string
     */
    protected string $name;

    /**
     * The size (width and height, in pixels) of the generated SVG avatar.
     *
     * @var int
     */
    protected int $size;

    /**
     * The palette of background colors to choose from.
     *
     * @var string[]
     */
    protected array $backgroundColors;

    /**
     * The color used for the initials text.
     *
     * @var string
     */
    protected string $foregroundColor;

    /**
     * Create a new instance of the class.
     *
     * @param  string  $name  The name used to compute the initials and color.
     * @param  array  $config  The avatar configuration (size, background
     *                         colors, and foreground color).
     * @return void
     */
    public function __construct(string $name, array $config = [])
    {
        $this->name = $name;
        $this->size = $config['size'] ?? self::DEFAULT_SIZE;

        $this->foregroundColor = $config['foreground_color']
            ?? self::DEFAULT_FOREGROUND_COLOR;

        $this->backgroundColors = $config['background_colors']
            ?? self::DEFAULT_BACKGROUND_COLORS;
    }

    /**
     * Get the initials computed from the name. If the name has multiple
     * words, the first letter of the first and last words is used. Otherwise,
     * the first two characters of the single word are used.
     *
     * @return string
     */
    public function getInitials(): string
    {
        // Split the name into words, ignoring extra whitespace. If there are
        // no words, return an empty string.

        $name = trim($this->name);
        $words = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);

        if (empty($words)) {
            return '';
        }

        // Compute the initials based on the number of words. If there is only
        // one word, use the first two characters. Otherwise, use the first
        // letter of the first and last words.

        if (count($words) === 1) {
            $initials = mb_substr($words[0], 0, 2);
        } else {
            $initials = mb_substr($words[0], 0, 1)
                .mb_substr($words[count($words) - 1], 0, 1);
        }

        // Return the initials in uppercase, using multibyte string functions
        // to handle Unicode characters correctly.

        return mb_strtoupper($initials);
    }

    /**
     * Get the background color deterministically picked from the configured
     * palette, based on the name. The same name will always produce the same
     * color.
     *
     * @return string
     */
    public function getBackgroundColor(): string
    {
        // Compute a simple hash of the name by summing the Unicode code points
        // of each character.

        $sum = array_sum(array_map('mb_ord', mb_str_split($this->name)));

        // Use the sum to pick a color from the palette, ensuring that the same
        // name always produces the same color.

        return $this->backgroundColors[$sum % count($this->backgroundColors)];
    }

    /**
     * Build the SVG markup for the avatar.
     *
     * @return string
     */
    public function toSvg(): string
    {
        // Compute the initials, background color, and other parameters needed
        // to generate the SVG markup.

        $initials = e($this->getInitials());
        $bgColor = $this->getBackgroundColor();
        $center = $this->size / 2;
        $fontSize = (int) round($this->size * 0.45);

        // Return the SVG markup as a string, using a heredoc for readability.
        // The SVG consists of a circle with the computed background color and
        // centered text with the initials.

        return <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="{$this->size}"
            height="{$this->size}" viewBox="0 0 {$this->size} {$this->size}">
            <circle cx="{$center}" cy="{$center}" r="{$center}"
                fill="{$bgColor}" />
            <text x="50%" y="47%" dy=".1em" fill="{$this->foregroundColor}"
                font-family="Roboto, sans-serif" font-size="{$fontSize}"
                font-weight="bold" text-anchor="middle"
                dominant-baseline="central">
                {$initials}
            </text>
        </svg>
        SVG;
    }
}
