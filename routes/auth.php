<?php

use DFSmania\LaradminLte\Http\Controllers\InitialsAvatarController;
use DFSmania\LaradminLte\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|------------------------------------------------------------------------------
| Local Initials Avatar
|------------------------------------------------------------------------------
|
| This route is public (not behind the auth middleware) so it behaves like
| a local avatar service (cacheable, no session required).
|
*/

if (config('ladmin.auth.features.profile_image', false)) {
    Route::get(
        '/ladmin/avatar/initials',
        [InitialsAvatarController::class, 'show']
    )->name('avatar.initials');
}

/*
|------------------------------------------------------------------------------
| Authentication Routes
|------------------------------------------------------------------------------
|
| These routes are protected by the authentication middlewares, and they
| provide access to several user-management features.
|
*/

// Define the base set of middlewares applied to the authentication routes.

$authMiddleware = ['web', 'auth'];

if (config('ladmin.auth.features.email_verification', false)) {
    $authMiddleware[] = 'verified';
}

// Define authentication routes within the specified middleware group.

Route::middleware($authMiddleware)->group(function () {

    /*
    |--------------------------------------------------------------------------
    | User Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/user/profile', [UserProfileController::class, 'show'])
        ->name('profile.show');

    /*
    |--------------------------------------------------------------------------
    | User Profile Image
    |--------------------------------------------------------------------------
    */

    if (config('ladmin.auth.features.profile_image', false)) {
        Route::put(
            '/user/profile_image',
            [UserProfileController::class, 'updateImage']
        )->name('user-profile-image.update');

        Route::delete(
            '/user/profile_image',
            [UserProfileController::class, 'deleteImage']
        )->name('user-profile-image.delete');
    }

    /*
    |--------------------------------------------------------------------------
    | User Account Deletion
    |--------------------------------------------------------------------------
    */

    if (config('ladmin.auth.features.account_deletion', false)) {
        Route::delete('/user', [UserProfileController::class, 'destroy'])
            ->name('user.destroy');
    }

    /*
    |--------------------------------------------------------------------------
    | User Sessions
    |--------------------------------------------------------------------------
    */

    if (config('ladmin.auth.features.browser_sessions', false)) {
        Route::delete(
            '/user/sessions',
            [UserProfileController::class, 'logoutOtherSessions']
        )->name('user-sessions.destroy');
    }
});
