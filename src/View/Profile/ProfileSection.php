<?php

namespace DFSmania\LaradminLte\View\Profile;

use Illuminate\View\Component;
use Illuminate\View\View;

class ProfileSection extends Component
{
    /**
     * The title of the profile section.
     *
     * @var string
     */
    public string $title;

    /**
     * The description of the profile section.
     *
     * @var string
     */
    public string $description;

    /**
     * Create a new component instance.
     *
     * @param  string  $title  The title of the profile section.
     * @param  string  $description  The description of the profile section.
     * @return void
     */
    public function __construct(string $title, string $description)
    {
        $this->title = html_entity_decode($title);
        $this->description = html_entity_decode($description);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::profile.profile-section');
    }
}
