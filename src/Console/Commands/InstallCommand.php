<?php

namespace DFSmania\LaradminLte\Console\Commands;

use DFSmania\LaradminLte\Support\Installation\InstallationResult;
use DFSmania\LaradminLte\Support\Installation\InstallationStatus;
use DFSmania\LaradminLte\Support\Installation\PublishableResource;
use DFSmania\LaradminLte\Support\Installation\PublishableResourceCatalog;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Laravel\Prompts\MultiSelectPrompt;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Formatter\OutputFormatter;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\note;
use function Laravel\Prompts\warning;

#[AsCommand(name: 'ladmin:install')]
class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ladmin:install
        {--resource=* : Install only the specified resources}
        {--force : Overwrite existing resources without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the LaradminLTE package resources';

    /**
     * Execute the console command.
     *
     * @param  PublishableResourceCatalog  $catalog  The catalog of resources.
     * @return int The exit status of the command.
     */
    public function handle(PublishableResourceCatalog $catalog): int
    {
        $this->components->info('LaradminLTE Installer');

        $resources = $this->option('resource');

        return $resources
            ? $this->handleInstallResources($catalog, $resources)
            : $this->handleStandardInstallation($catalog);
    }

    /**
     * Handle installation of explicitly selected resources.
     *
     * @param  PublishableResourceCatalog  $catalog  The catalog of resources.
     * @param  array<string>  $keys  The keys of the resources to install.
     * @return int The exit status of the command.
     */
    private function handleInstallResources(
        PublishableResourceCatalog $catalog,
        array $keys,
    ): int {
        // Resolve the requested resources, ignoring duplicate keys.

        $keys = array_values(array_unique($keys));

        $resources = collect($keys)->map(
            fn (string $key) => $catalog->get($key)
        );

        // Reject unknown resource keys before installing anything.

        if ($resources->contains(null)) {
            $unknown = collect($keys)->filter(
                fn (string $key) => $catalog->get($key) === null
            );

            $this->components->error(
                'Unknown resources: '.$unknown->implode(', ')
            );

            $this->components->warn(
                'Available resources: '.$catalog->all()->keys()->implode(', ')
            );

            return self::FAILURE;
        }

        // Install the requested resources.

        $results = collect();

        foreach ($resources as $resource) {
            $results->put($resource->key, $this->installResource($resource));
        }

        // Finish the installation and return the result.

        return $this->finishInstallation($results);
    }

    /**
     * Handle the standard installation workflow for required and optional
     * resources.
     *
     * @param  PublishableResourceCatalog  $catalog  The catalog of resources.
     * @return int The exit status of the command.
     */
    private function handleStandardInstallation(
        PublishableResourceCatalog $catalog
    ): int {
        // Initialize the installation results collection.

        $results = collect();

        // Install the required resources.

        foreach ($catalog->required() as $resource) {
            $results->put($resource->key, $this->installResource($resource));
        }

        // Offer to install optional resources.

        $optionalResources = $catalog->optional();

        $selected = $this->input->isInteractive()
            ? $this->selectOptionalResources($optionalResources)
            : [];

        // Install or skip optional resources.

        foreach ($optionalResources as $resource) {
            $result = in_array($resource->key, $selected, true)
                ? $this->installResource($resource)
                : new InstallationResult(
                    resource: $resource,
                    status: InstallationStatus::Skipped,
                    destinations: array_values(
                        $resource->inspect()['destinations']
                    ),
                );

            $results->put($resource->key, $result);
        }

        // Finish the installation and return the result.

        return $this->finishInstallation($results);
    }

    /**
     * Install a specific publishable resource.
     *
     * @param  PublishableResource  $resource  The resource to install.
     * @return InstallationResult The result of the installation attempt.
     */
    private function installResource(
        PublishableResource $resource
    ): InstallationResult {
        // Inspect the current installation state of the resource.

        $inspection = $resource->inspect();
        $force = (bool) $this->option('force');

        // Determine whether to ask before overwriting existing files.

        $warnOverwrite = ! $force
            && count($inspection['existing']) > 0
            && $this->input->isInteractive();

        if ($warnOverwrite) {
            warning("{$resource->name} already contains published files.");

            $force = confirm(
                label: "Overwrite existing {$resource->name} files?",
                default: false,
                hint: 'If you overwrite, existing customizations may be lost.',
            );
        }

        // Publish the resource and return the installation result.

        $result = $this->publishResource($resource, $force, $inspection);

        match ($result->status) {
            InstallationStatus::Installed => info(
                "{$resource->name} installed successfully."
            ),
            InstallationStatus::Updated => info(
                "{$resource->name} updated successfully."
            ),
            InstallationStatus::Failed => warning(
                "Failed to install {$resource->name}."
            ),
            default => null,
        };

        return $result;
    }

    /**
     * Publish a resource and determine its installation result.
     *
     * @param  PublishableResource  $resource  The resource to publish.
     * @param  bool  $force  Whether to overwrite existing files.
     * @param  array  $beforeInspection  The current state of the resource
     *                                   before publishing.
     * @return InstallationResult The result of the installation.
     */
    private function publishResource(
        PublishableResource $resource,
        bool $force,
        array $beforeInspection,
    ): InstallationResult {
        // Inspect the current state of the resource before publishing.

        $hasExisting = count($beforeInspection['existing']) > 0;
        $hasMissing = count($beforeInspection['missing']) > 0;

        // Nothing to publish if all files exist and overwriting is disabled.

        if (! $hasMissing && ! $force) {
            return new InstallationResult(
                resource: $resource,
                status: InstallationStatus::Unchanged,
                destinations: $beforeInspection['destinations'],
            );
        }

        // Publish the resource using callSilently to avoid output clutter.

        $exitCode = $this->callSilently('vendor:publish', [
            '--tag' => $resource->tag,
            '--force' => $force,
        ]);

        // Inspect the resource after publishing.

        $after = $resource->inspect();

        // Determine the installation status.

        $status = match (true) {
            $exitCode !== self::SUCCESS || count($after['missing']) > 0 => (
                InstallationStatus::Failed
            ),
            $force && $hasExisting => InstallationStatus::Updated,
            default => InstallationStatus::Installed,
        };

        // Return the installation result with the determined status and
        // destinations.

        return new InstallationResult(
            resource: $resource,
            status: $status,
            destinations: $after['destinations'],
        );
    }

    /**
     * Prompt the user to select optional resources to install.
     *
     * @param  Collection  $resources  The collection of optional resources.
     * @return array The selected optional resources keys.
     */
    private function selectOptionalResources(Collection $resources): array
    {
        // Check the constructor parameters of the MultiSelectPrompt class to
        // determine if the 'info' parameter is supported.

        $supportedParams = array_map(
            fn (\ReflectionParameter $parameter) => $parameter->getName(),
            (new \ReflectionMethod(MultiSelectPrompt::class, '__construct'))
                ->getParameters()
        );

        // Prompt the user to select optional resources to install, and return
        // the selected ones.

        note(
            "Select additional LaradminLTE resources you want to install.\n"
            ."Use 'space' to select, 'enter' to continue. Leave empty to skip "
            .'all.'
        );

        $options = $resources->mapWithKeys(
            fn (PublishableResource $resource) => [
                $resource->key => $resource->name,
            ]
        )->all();

        $arguments = [
            'label' => 'Optional resources',
            'options' => $options,
            'default' => [],
            'hint' => 'These resources can also be published later.',
            'required' => false,
        ];

        if (in_array('info', $supportedParams, true)) {
            $arguments['info'] = fn ($key) => $resources->get($key)?->help;
        }

        return multiselect(...$arguments);
    }

    /**
     * Finish the installation process by displaying the summary and returning
     * the exit status.
     *
     * @param  Collection<string, InstallationResult>  $results
     * @return int The exit status of the command.
     */
    private function finishInstallation(Collection $results): int
    {
        // Display the installation summary.

        $this->displaySummary($results);

        // Return the installation process result.

        $someInstallationFailed = $results->contains(
            fn (InstallationResult $result) => $result->failed()
        );

        return $someInstallationFailed ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Display a summary of the installation results.
     *
     * @param  Collection<string, InstallationResult>  $results
     */
    private function displaySummary(Collection $results): void
    {
        // Display the installation summary header.

        $this->newLine();
        $this->components->info('LaradminLTE Installation Summary');

        // Prepare the rows for the installation summary table.

        $rows = $results->map(function (InstallationResult $result) {
            $destinations = OutputFormatter::escape(
                implode("\n", $result->destinations)
            );

            return [
                $result->resource->name,
                $this->formatStatus($result->status),
                '<fg=#888888>'.$destinations.'</>',
            ];
        })->all();

        // Display the installation summary table.

        $this->table(
            ['Resource', 'Status', 'Destination'],
            $rows,
        );

        // Check if any migrations were installed and display a warning if
        // needed.

        $migrations = $results->get('migrations');

        if ($migrations?->wasInstalled()) {
            $this->components->warn(
                'Run "php artisan migrate" to apply the database migrations.'
            );
        }
    }

    /**
     * Format an installation status for console output.
     *
     * @param  InstallationStatus  $status  The installation status to format.
     * @return string The formatted status string for console output.
     */
    private function formatStatus(InstallationStatus $status): string
    {
        $color = match ($status) {
            InstallationStatus::Installed => 'green',
            InstallationStatus::Updated => 'cyan',
            InstallationStatus::Failed => 'red',
            InstallationStatus::Unchanged => 'white',
            InstallationStatus::Skipped => '#888888',
        };

        return "<fg={$color}>{$status->value}</>";
    }
}
