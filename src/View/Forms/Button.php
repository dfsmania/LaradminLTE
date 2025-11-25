<?php

namespace DFSmania\LaradminLte\View\Forms;

use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    /**
     * The visible label for the button (optional). This is used to provide a
     * descriptive text for the button.
     *
     * @var ?string
     */
    public ?string $label;

    /**
     * The icon for the button (optional). This should be a valid FontAwesome
     * or Bootstrap icon class (e.g., 'fas fa-plus', 'bi bi-check', etc.),
     * depending on the icon library used in the project.
     *
     * @var ?string
     */
    public ?string $icon;

    /**
     * The set of CSS classes for the "button" element. This will hold the set
     * of classes that define the button's appearance based on the theme and
     * size.
     *
     * @var string
     */
    public string $buttonClasses;

    /**
     * Create a new component instance.
     *
     * @param  ?string  $label  The visible label for the button
     * @param  ?string  $theme  The color theme for the button
     * @param  ?string  $icon  The icon for the button
     * @param  ?string  $sizing  The size modifier for the button ('sm' or 'lg')
     * @return void
     */
    public function __construct(
        ?string $label = null,
        ?string $theme = 'secondary',
        ?string $icon = null,
        ?string $sizing = null
    ) {
        // If a label is provided, use html_entity_decode() method to support
        // HTML entities in the label text. Otherwise, set it to null.

        $this->label = ! empty($label) ? html_entity_decode($label) : null;
        $this->icon = $icon;

        // Setup the CSS classes for the button based on the provided theme
        // and size.

        $sizing = in_array($sizing, ['sm', 'lg']) ? $sizing : null;
        $this->buttonClasses = $this->getButtonClasses($theme, $sizing);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('ladmin::forms.button');
    }

    /**
     * Resolve the CSS classes for the button element based on the theme and
     * size.
     *
     * @param  string  $theme  The color theme for the button
     * @param  ?string  $size  The size modifier for the button ('sm' or 'lg')
     * @return string
     */
    protected function getButtonClasses(
        string $theme,
        ?string $size = null
    ): string {
        // Setup base button class and theme modifier class.

        $classes = ['btn', "btn-{$theme}"];

        // Add size modifier class if a valid size is provided.

        if (! empty($size)) {
            $classes[] = "btn-{$size}";
        }

        return implode(' ', $classes);
    }
}
