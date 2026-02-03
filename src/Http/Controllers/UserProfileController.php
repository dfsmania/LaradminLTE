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
    public function deleteImage(Request $request)
    {
        $request->user()->deleteProfileImage();

        return back()->with('status', 'profile-image-deleted');
    }
}
