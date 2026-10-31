<?php

namespace DFSmania\LaradminLte\Support\Installation;

use DFSmania\LaradminLte\LaradminLteServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

/**
 * Class representing a publishable resource in LaradminLTE.
 */
class PublishableResource
{
    /**
     * The unique key identifying the publishable resource.
     *
     * @var string
     */
    public readonly string $key;

    /**
     * The display name of the publishable resource.
     *
     * @var string
     */
    public readonly string $name;

    /**
     * The publish tag associated with the publishable resource.
     *
     * @var string
     */
    public readonly string $tag;

    /**
     * Indicates whether the publishable resource is required by the
     * installation process.
     *
     * @var bool
     */
    public readonly bool $required;

    /**
     * The help text for the publishable resource.
     *
     * @var string
     */
    public readonly string $help;

    /**
     * Create a new publishable resource instance.
     */
    public function __construct(
        string $key,
        string $name,
        string $tag,
        bool $required,
        string $help,
    ) {
        $this->key = $key;
        $this->name = $name;
        $this->tag = $tag;
        $this->required = $required;
        $this->help = $help;
    }

    /**
     * Determine if the resource is required.
     *
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * Determine if the resource is optional.
     *
     * @return bool
     */
    public function isOptional(): bool
    {
        return ! $this->required;
    }

    /**
     * Get the publish paths for this resource.
     *
     * @return array The publish paths for this resource.
     */
    public function getPublishPaths(): array
    {
        return ServiceProvider::pathsToPublish(
            provider: LaradminLteServiceProvider::class,
            group: $this->tag,
        );
    }

    /**
     * Inspect the resource to determine existing and missing files relative to
     * its publish paths.
     *
     * @return array An array containing 'existing', 'missing', and
     *               'destinations' keys.
     */
    public function inspect(): array
    {
        // Initialize arrays to keep track of existing, missing, and
        // destination files.

        $existing = $missing = $destinations = [];

        // Iterate over each publish path and determine which files already
        // exist and which are missing.

        foreach ($this->getPublishPaths() as $source => $destination) {
            $destinations[] = $destination;

            // Get all the destination paths for the current source and
            // destination.

            $resourceDestinations = $this->getResourceDestinations(
                $source,
                $destination
            );

            // For all resource destinations, check if the file exists and
            // categorize it as existing or missing.

            foreach ($resourceDestinations as $target) {
                if (File::exists($target)) {
                    $existing[] = $target;
                } else {
                    $missing[] = $target;
                }
            }
        }

        // Return the arrays of existing, missing, and unique destination files.

        return [
            'existing' => $existing,
            'missing' => $missing,
            'destinations' => array_values(array_unique($destinations)),
        ];
    }

    /**
     * Get the destination paths for a given source and destination.
     *
     * This method will return all the destination paths for the given source,
     * whether it is a file or a directory.
     *
     * @param  string  $source  The source path.
     * @param  string  $destination  The destination path.
     * @return array The destination paths of the resource.
     */
    private function getResourceDestinations(
        string $source,
        string $destination
    ): array {
        // If the source is a file, return the destination as a single-element
        // array, since there is only one corresponding destination path.

        if (File::isFile($source)) {
            return [$destination];
        }

        // If the source is not a directory, return an empty array. This
        // handles the case where the source path is invalid or does not exist.

        if (! File::isDirectory($source)) {
            return [];
        }

        // At this point, the source is a directory, so we will iterate over
        // all files within it and construct their corresponding destination
        // paths.

        $destinations = [];

        foreach (File::allFiles($source) as $file) {
            $destinations[] = rtrim($destination, '/\\')
                .DIRECTORY_SEPARATOR
                .$file->getRelativePathname();
        }

        return $destinations;
    }
}
