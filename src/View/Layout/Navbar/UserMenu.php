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
     * The url path of the user image to be displayed in the user menu.
     *
     * @var string
     */
    public string $userImageUrl;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Get the authenticated user.

        $user = auth()->user();

        // Set user properties with fallbacks. Note when the special
        // 'ladmin_image' attribute is not implemented in the User model, we
        // will fallback to a Gravatar by default.

        $this->userName = $user?->name ?? 'Guest';
        $this->userEmail = $user?->email ?? 'guest@example.com';
        $this->userImageUrl = $user?->ladmin_image
            ?? $this->getGravatarUrl($this->userEmail);
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

    /**
     * Get the Gravatar URL for the given email address.
     *
     * @param  string  $email  The email address.
     * @param  int  $size  The size of the Gravatar image (default: 200).
     * @return string
     */
    protected function getGravatarUrl(string $email, int $size = 200): string
    {
        $hash = md5(strtolower(trim($email)));

        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s={$size}";
    }
}
