<?php

namespace DFSmania\LaradminLte\Models\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Trait for handling the profile image feature on the User model.
 * To enable profile image support, you should include this trait in the User
 * model of your Laravel application.
 */
trait HasProfileImage
{
    /**
     * Update the user's profile image.
     *
     * @param  \Illuminate\Http\UploadedFile  $image  The uploaded image file.
     * @return void
     */
    public function updateProfileImage(UploadedFile $image): void
    {
        // Store the new image and delete the previous one if it exists. Note
        // we use tap() to get the previous path before updating it, and hold
        // it in a variable for deletion after the update.

        tap($this->profile_image_path, function ($previous) use ($image) {
            // Retrieve storage disk and path.

            $disk = $this->profileImageDisk();
            $path = $this->profileImagePath();

            // Store the new image. The image will be stored with a random
            // unique filename to avoid conflicts.

            $storedPath = $image->storePublicly($path, ['disk' => $disk]);

            // Update the user's profile image path.

            $this->forceFill(['profile_image_path' => $storedPath])->save();

            // Delete previous image if it existed.

            if ($previous) {
                Storage::disk($disk)->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile image. After this operation, the user will
     * have no profile image associated with their account, and the default
     * profile image will be used instead.
     *
     * @return void
     */
    public function deleteProfileImage(): void
    {
        // Check there is a profile image to delete.

        if (! $this->profile_image_path) {
            return;
        }

        // Delete the image from storage.

        Storage::disk($this->profileImageDisk())
            ->delete($this->profile_image_path);

        // Set the profile image path to null.

        $this->forceFill(['profile_image_path' => null])->save();
    }

    /**
     * Gets the URL of the user's profile image. If the user has not uploaded
     * a profile image, the default profile image URL will be returned.
     *
     * @return string
     */
    public function profileImageUrl(): string
    {
        // Retrieve the storage disk.

        $disk = $this->profileImageDisk();

        // Check if the image file exists in storage. If it does, return its
        // URL. Otherwise, return the default profile image URL.

        $imageExists = $this->profile_image_path
            && Storage::disk($disk)->exists($this->profile_image_path);

        return $imageExists
            ? Storage::disk($disk)->url($this->profile_image_path)
            : $this->defaultProfileImageUrl();
    }

    /**
     * Gets the URL of the user's default profile image. This URL is generated
     * with an external service based on the user's name (ui-avatars.com) or
     * email (Gravatar). The service to use is determined by configuration.
     *
     * @return string
     */
    protected function defaultProfileImageUrl(): string
    {
        $mode = config('ladmin.auth.profile_images.default_mode', 'initials');

        if ($mode === 'initials') {
            return $this->getUiAvatarsUrl($this->name);
        } else {
            return $this->getGravatarUrl($this->email, $mode);
        }
    }

    /**
     * Get the ui-avatars.com URL for the user's name. This URL will contain an
     * image with the user's initials.
     *
     * @param  string  $name  The user's name.
     * @return string
     */
    protected function getUiAvatarsUrl(string $name): string
    {
        $name = urlencode($name);
        $config = 'size=128&background=random&bold=true';

        return "https://ui-avatars.com/api/?name={$name}&{$config}";
    }

    /**
     * Get the Gravatar URL for the user's email address. This URL will contain
     * a generated image based on the specified mode.
     *
     * @param  string  $email  The user's email address.
     * @param  string  $mode  The gravatar image mode to use.
     * @return string
     */
    protected function getGravatarUrl(
        string $email,
        string $mode = 'identicon'
    ): string {
        $emailHash = md5(strtolower(trim($email)));

        return "https://www.gravatar.com/avatar/{$emailHash}?s=128&d={$mode}";
    }

    /**
     * Get the storage disk used for profile images.
     *
     * @return string
     */
    protected function profileImageDisk(): string
    {
        return config('ladmin.auth.profile_images.storage_disk', 'public');
    }

    /**
     * Get the storage path, within the storage disk, used for profile images.
     *
     * @return string
     */
    protected function profileImagePath(): string
    {
        return config(
            'ladmin.auth.profile_images.storage_path',
            'profile-images'
        );
    }
}
