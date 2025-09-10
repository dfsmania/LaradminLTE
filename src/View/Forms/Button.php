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
     * The color theme for the button (optional). Accepts any valid Bootstrap
     * theme such as 'primary', 'secondary', 'success', 'danger', 'warning',
     * 'info', 'light', 'dark', or 'link', including 'outline-' variants
     * (e.g., 'outline-primary'). Determines the button's appearance.
     * Default is 'secondary'.
     *
     * @var string
     */
    public string $theme;

    /**
     * The icon for the button (optional). This should be a valid FontAwesome
     * or Bootstrap icon class (e.g., 'fas fa-plus', 'bi bi-check', etc.),
     * depending on the icon library used in the project.
     *
     * @var ?string
     */
    public ?string $icon;

    /**
     * Create a new component instance.
     *
     * @param  ?string  $label  The visible label for the button
     * @param  ?string  $theme  The color theme for the button
     * @param  ?string  $icon  The icon for the button
     * @return void
     */
    public function __construct(
        ?string $label = null,
        ?string $theme = 'secondary',
        ?string $icon = null
    ) {
        // If a label is provided, use html_entity_decode() method to support
        // HTML entities in the label text. Otherwise, set it to null.

        $this->label = ! empty($label) ? html_entity_decode($label) : null;
        $this->theme = $theme;
        $this->icon = $icon;
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
}
