<?php

namespace DFSmania\LaradminLte\View\Layout\Navbar;

use Illuminate\View\Component;
use Illuminate\View\View;

class UserMenu extends Component
{
    /**
     * The user name to be displayed in the user menu.
     *
     * @var string
     */
    public string $userName;

    /**
     * The user email to be displayed in the user menu.
     *
     * @var string
     */
    public string $userEmail;

    /**
     * The url path of the user image to be displayed in the user menu. Note
     * this can be null if no image is available.
     *
     * @var ?string
     */
    public ?string $userImageUrl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Get the authenticated user.

        $user = auth()->user();

        // Set the user basic properties with fallbacks.

        $this->userName = $user?->name ?? 'Guest';
        $this->userEmail = $user?->email ?? 'guest@example.com';

        // Set the user image URL if the profile image feature is enabled.

        $imageEnabled = config('ladmin.auth.features.profile_image', false)
            && method_exists($user, 'profileImageUrl');

        $this->userImageUrl = $imageEnabled ? $user->profileImageUrl() : null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render(): View|string
    {
        return view('ladmin::layout.navbar.user-menu');
    }
}
