<?php

namespace DFSmania\LaradminLte\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserProfileController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('ladmin::profile.show', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateImage(Request $request): RedirectResponse
    {
        // Read configuration for profile image validation.

        $maxSize = config('ladmin.auth.profile_images.max_size', 2048);
        $allowedMimeTypes = config(
            'ladmin.auth.profile_images.allowed_mime_types',
            ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
        );

        // Validate the uploaded image file. Note we use a custom error bag
        // named 'updateProfileImage' to separate these validation errors from
        // others that may occur on the profile page.

        $request->validateWithBag('updateProfileImage', [
            'photo' => [
                'required',
                'image',
                'max:'.$maxSize,
                'mimetypes:'.implode(',', $allowedMimeTypes),
            ],
        ]);

        // Update the user's profile image.

        $request->user()->updateProfileImage($request->file('photo'));

        // Redirect back with success status.

        return back()->with('status', 'profile-image-updated');
    }

    /**
     * Delete the user's profile image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage(Request $request): RedirectResponse
    {
        $request->user()->deleteProfileImage();

        return back()->with('status', 'profile-image-deleted');
    }

    /**
     * Permanently delete the user's account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate the password before allowing account deletion. We use a
        // custom error bag named 'deleteAccount' to keep these validation
        // errors separate from other potential errors on the profile page.

        $request->validateWithBag('deleteAccount', [
            'password' => [
                'required',
                'current_password',
            ],
        ]);

        // At this point, the password is valid and we can proceed with account
        // deletion. We start by deleting the profile image and revoking any
        // tokens, if these action are required (i.e. if the corresponding
        // methods exist on the User model). This ensures that we clean up any
        // related resources before deleting the user account itself.

        $user = $request->user();

        if (method_exists($user, 'deleteProfileImage')) {
            $user->deleteProfileImage();
        }

        if (method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

        // Finally, we delete the user account, log out the user, invalidate
        // the session, and regenerate the CSRF token to ensure a clean state
        // after account deletion.

        auth()->logout();
        $user->delete();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Redirect to the login page after account deletion.

        return redirect(route('login'))->with(
            'status',
            __('ladmin::auth.profile.delete_account.account_deleted')
        );
    }
}
