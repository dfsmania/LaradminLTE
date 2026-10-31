<?php

namespace DFSmania\LaradminLte\Support\Installation;

/**
 * Class representing the result of installing a publishable resource.
 */
class InstallationResult
{
    /**
     * The publishable resource associated with this installation result.
     *
     * @var PublishableResource
     */
    public readonly PublishableResource $resource;

    /**
     * The installation status of the resource.
     *
     * @var InstallationStatus
     */
    public readonly InstallationStatus $status;

    /**
     * The destination paths for the resource.
     *
     * @var array<string>
     */
    public readonly array $destinations;

    /**
     * Create a new installation result instance.
     */
    public function __construct(
        PublishableResource $resource,
        InstallationStatus $status,
        array $destinations,
    ) {
        $this->resource = $resource;
        $this->status = $status;
        $this->destinations = $destinations;
    }

    /**
     * Determine if the installation failed.
     *
     * @return bool
     */
    public function failed(): bool
    {
        return $this->status === InstallationStatus::Failed;
    }

    /**
     * Determine if the resource was installed or updated.
     *
     * @return bool
     */
    public function wasInstalled(): bool
    {
        return in_array($this->status, [
            InstallationStatus::Installed,
            InstallationStatus::Updated,
        ], true);
    }
}
