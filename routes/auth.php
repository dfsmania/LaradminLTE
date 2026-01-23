<?php

use DFSmania\LaradminLte\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

// Define the array of middlewares to be applied to the authentication routes.

$authMiddleware = ['web', 'auth'];

if (config('ladmin.auth.features.email_verification')) {
    $authMiddleware[] = 'verified';
}

// Define the extra middlewares applied to the get user profile route.

$profileMiddleware = [];

if (config('ladmin.auth.features.protect_profile_access')) {
    $profileMiddleware[] = 'password.confirm';
}

// Define authentication related routes within the specified middleware group.

Route::middleware($authMiddleware)->group(function () use ($profileMiddleware) {

    // Get user profile route. This route may also be protected by the password
    // confirmation middleware for security reasons.
    Route::get('/user/profile', [UserProfileController::class, 'show'])
        ->name('profile.show')
        ->middleware($profileMiddleware);
});
