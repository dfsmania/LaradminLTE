<?php

namespace DFSmania\LaradminLte\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class UserProfileController extends Controller
{
    /**
     * Show the user profile screen.
     *
     * @param  Request  $request
     * @return View
     */
    public function show(Request $request): View
    {
        return view('ladmin::profile.show', [
            'request' => $request,
            'user' => $request->user(),
            'sessions' => $this->getSessions($request),
        ]);
    }

    /**
     * Update the user's profile image.
     *
     * @param  Request  $request
     * @return RedirectResponse
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
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function deleteImage(Request $request): RedirectResponse
    {
        $request->user()->deleteProfileImage();

        return back()->with('status', 'profile-image-deleted');
    }

    /**
     * Permanently delete the user's account.
     *
     * @param  Request  $request
     * @return RedirectResponse
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

    /**
     * Log out the user from other browser sessions. Only current session will
     * remain active.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function logoutOtherSessions(Request $request): RedirectResponse
    {
        // Check if browser sessions management is allowed. If not allowed, we
        // simply abort with a 404 error.

        if (! $this->isSessionManagementAllowed()) {
            abort(404);
        }

        // Validate the password before allowing logging out other sessions.
        // Note we use a custom error bag named 'logoutOtherSessions' to keep
        // these validation errors separate from other potential errors on the
        // profile page.

        $request->validateWithBag('logoutOtherSessions', [
            'password' => [
                'required',
                'current_password',
            ],
        ]);

        // If the password is valid, we proceed to invalidate and log out other
        // sessions for the user.

        auth()->logoutOtherDevices($request->password);

        // After logging out other sessions, we also delete any remaining
        // sessions for the user from the database, except for the current
        // session. This ensures that all other sessions are fully terminated,
        // even if they were not properly logged out due to issues like network
        // connectivity or browser crashes.

        $user = $request->user();

        DB::connection(config('session.connection'))
            ->table(config('session.table', 'sessions'))
            ->where('user_id', $user->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        // Prevent current session from being logged out by storing the current
        // password hash in the session. This is necessary because Laravel's
        // default implementation of the "logoutOtherDevices" method relies on
        // comparing the current password hash with the one stored in the
        // session to determine which sessions to log out. By updating the
        // session with the current password hash, we ensure that the current
        // session remains active while all other sessions are logged out.

        $passHashKey = 'password_hash_'.auth()->getDefaultDriver();
        $request->session()->put([$passHashKey => $user->getAuthPassword()]);

        // Redirect back with success status.

        return back()->with('status', 'other-sessions-logged-out');
    }

    /**
     * Get the sessions for the authenticated user.
     *
     * @param  Request  $request
     * @return Collection
     */
    protected function getSessions(Request $request): Collection
    {
        // Check if browser sessions management is allowed. If not allowed, we
        // return an empty collection.

        if (! $this->isSessionManagementAllowed()) {
            return collect();
        }

        // If sessions are allowed, we retrieve the user's sessions from the
        // database.

        $sessions = DB::connection(config('session.connection'))
            ->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->orderBy('last_activity', 'desc')
            ->get();

        // We then map over the sessions to create a collection of session
        // objects that include the agent information, IP address, whether it's
        // the current device, and the last active time. Note we use a
        // third-party package (jenssegers/agent) to parse the user agent
        // string and extract information about the device and browser used.

        $agent = new Agent;

        return $sessions->map(function ($session) use ($request, $agent) {
            $agent->setUserAgent($session->user_agent ?? '');

            $isCurrentDevice = $session->id === $request->session()->getId();

            $lastActive = Carbon::createFromTimestamp($session->last_activity)
                ->diffForHumans();

            return (object) [
                'agent' => $agent,
                'ip_address' => $session->ip_address,
                'is_current_device' => $isCurrentDevice,
                'last_active' => $lastActive,
            ];
        });
    }

    /**
     * Determine if the browser session management feature is allowed based on
     * the session driver and the corresponding feature flag in the
     * configuration.
     *
     * @return bool
     */
    protected function isSessionManagementAllowed(): bool
    {
        return config('ladmin.auth.features.browser_sessions', false)
            && config('session.driver') === 'database';
    }
}
