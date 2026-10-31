<?php

namespace DFSmania\LaradminLte\Tests\Feature\Console\Commands;

use DFSmania\LaradminLte\Support\Installation\PublishableResource;
use DFSmania\LaradminLte\Support\Installation\PublishableResourceCatalog;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class InstallCommandTest extends TestCase
{
    /**
     * The temporary directory used for filesystem tests.
     *
     * @var string
     */
    private string $testDirectory;

    /**
     * Set up the test environment.
     */
    protected function setUp(): void
    {
        // Call the parent setUp method to initialize the test environment.

        parent::setUp();

        // Create a unique temporary directory for this test instance.

        $this->testDirectory = sys_get_temp_dir()
            .'/laradminlte-install-'.uniqid();

        File::ensureDirectoryExists($this->testDirectory);

        // Register the test resources for this test instance.

        $this->registerTestResources();
    }

    /**
     * Clean up the test environment.
     */
    protected function tearDown(): void
    {
        // Clean up the test resources for this test instance.

        if (isset($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

        // Call the parent tearDown method to complete the cleanup process.

        parent::tearDown();
    }

    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_installs_required_resources(): void
    {
        $this->artisan('ladmin:install', [
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertResourcePublished('assets');
        $this->assertResourcePublished('config');
    }

    public function test_it_skips_optional_resources_in_non_interactive(): void
    {
        $this->artisan('ladmin:install', [
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertResourceNotPublished('translations');
        $this->assertResourceNotPublished('migrations');
    }

    public function test_it_installs_only_the_requested_resource(): void
    {
        $this->artisan('ladmin:install', [
            '--resource' => ['translations'],
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertResourcePublished('translations');
        $this->assertResourceNotPublished('assets');
        $this->assertResourceNotPublished('config');
        $this->assertResourceNotPublished('migrations');
    }

    public function test_it_installs_multiple_requested_resources(): void
    {
        $this->artisan('ladmin:install', [
            '--resource' => ['assets', 'translations'],
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertResourcePublished('assets');
        $this->assertResourcePublished('translations');
        $this->assertResourceNotPublished('config');
        $this->assertResourceNotPublished('migrations');
    }

    public function test_it_ignores_duplicate_resource_keys(): void
    {
        $this->artisan('ladmin:install', [
            '--resource' => ['assets', 'assets'],
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertResourcePublished('assets');
        $this->assertResourceNotPublished('config');
    }

    public function test_it_rejects_unknown_resources_before_installing(): void
    {
        $this->artisan('ladmin:install', [
            '--resource' => ['assets', 'unknown'],
            '--no-interaction' => true,
        ])->assertFailed();

        $this->assertResourceNotPublished('assets');
    }

    public function test_it_preserves_existing_files_without_force(): void
    {
        $destination = $this->resourceDestination('config');
        File::put($destination, 'Customized content');

        $this->artisan('ladmin:install', [
            '--resource' => ['config'],
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertSame(
            'Customized content',
            File::get($destination)
        );
    }

    public function test_it_publishes_missing_files_without_overwriting(): void
    {
        $existing = $this->resourceDestination('assets');
        $missing = $this->resourceDestination('assets', 'extra.txt');
        File::put($existing, 'Customized content');

        $this->artisan('ladmin:install', [
            '--resource' => ['assets'],
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertSame(
            'Customized content',
            File::get($existing)
        );

        $this->assertFileExists($missing);

        $this->assertSame(
            'Additional assets content',
            File::get($missing)
        );
    }

    public function test_it_overwrites_existing_files_with_force(): void
    {
        $destination = $this->resourceDestination('config');
        File::put($destination, 'Customized content');

        $this->artisan('ladmin:install', [
            '--resource' => ['config'],
            '--force' => true,
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertSame(
            'Original config content',
            File::get($destination)
        );
    }

    public function test_it_warns_when_migrations_are_installed(): void
    {
        $this->artisan('ladmin:install', [
            '--resource' => ['migrations'],
            '--no-interaction' => true,
        ])
            ->expectsOutputToContain('php artisan migrate')
            ->assertSuccessful();

        $this->assertResourcePublished('migrations');
    }

    public function test_it_installs_selected_optional_resources(): void
    {
        $this->artisan('ladmin:install')
            ->expectsQuestion(
                'Optional resources',
                ['translations', 'migrations'],
            )
            ->assertSuccessful();

        $this->assertResourcePublished('assets');
        $this->assertResourcePublished('config');
        $this->assertResourcePublished('translations');
        $this->assertResourcePublished('migrations');
    }

    public function test_it_skips_unselected_optional_resources(): void
    {
        $this->artisan('ladmin:install')
            ->expectsQuestion(
                'Optional resources',
                [],
            )
            ->assertSuccessful();

        $this->assertResourcePublished('assets');
        $this->assertResourcePublished('config');
        $this->assertResourceNotPublished('translations');
        $this->assertResourceNotPublished('migrations');
    }

    public function test_it_overwrites_existing_files_when_confirmed(): void
    {
        $destination = $this->resourceDestination('config');
        File::put($destination, 'Customized content');

        $this->artisan('ladmin:install', [
            '--resource' => ['config'],
        ])
            ->expectsConfirmation(
                'Overwrite existing Config files?',
                'yes'
            )
            ->assertSuccessful();

        $this->assertSame(
            'Original config content',
            File::get($destination)
        );
    }

    public function test_it_preserves_files_when_overwrite_is_declined(): void
    {
        $destination = $this->resourceDestination('config');
        File::put($destination, 'Customized content');

        $this->artisan('ladmin:install', [
            '--resource' => ['config'],
        ])
            ->expectsConfirmation(
                'Overwrite existing Config files?',
                'no'
            )
            ->assertSuccessful();

        $this->assertSame(
            'Customized content',
            File::get($destination)
        );
    }

    public function test_it_fails_when_resource_cannot_be_published(): void
    {
        // Simulate a failing vendor:publish command.

        $this->app->make(Kernel::class)
            ->registerCommand(new class extends Command
            {
                protected $signature = 'vendor:publish {--tag=} {--force}';

                public function handle(): int
                {
                    return self::FAILURE;
                }
            });

        // Attempt to install the resource, which should fail due to the
        // simulated failing vendor:publish command.

        $this->artisan('ladmin:install', [
            '--resource' => ['config'],
            '--no-interaction' => true,
        ])->assertFailed();

        $this->assertResourceNotPublished('config');
    }

    // ------------------------------------------------------------------------
    // HELPER METHODS
    // ------------------------------------------------------------------------

    /**
     * Register isolated publishable resources for testing.
     */
    private function registerTestResources(): void
    {
        // Declare the test resources and their publish paths.

        $resources = collect();
        $publishPaths = [];

        // Initialize the test resources and their publish paths.

        $resourcesMap = [
            'assets' => true,
            'config' => true,
            'translations' => false,
            'migrations' => false,
        ];

        foreach ($resourcesMap as $key => $required) {
            // Determine and create the source and destination paths for the
            // resource.

            $source = $this->testDirectory."/sources/{$key}.txt";
            $destination = $this->resourceDestination($key);

            File::ensureDirectoryExists(dirname($source));
            File::ensureDirectoryExists(dirname($destination));

            File::put($source, "Original {$key} content");

            $paths = [$source => $destination];

            // Add a second file to the assets resource to test
            // partially published resources.

            if ($key === 'assets') {
                $extraSource = $this->testDirectory.'/sources/assets-extra.txt';

                $extraDestination = $this->resourceDestination(
                    'assets',
                    'extra.txt'
                );

                File::put($extraSource, 'Additional assets content');
                $paths[$extraSource] = $extraDestination;
            }

            // Create a new test install publishable resource.

            $resource = new TestInstallPublishableResource(
                key: $key,
                name: ucfirst($key),
                tag: "test-ladmin-{$key}",
                required: $required,
                help: "Test {$key} resource.",
                paths: $paths,
            );

            // Add the resource to the collection of test resources.

            $publishPaths[$resource->tag] = $paths;
            $resources->put($key, $resource);
        }

        // Register the test publishing paths through a service provider.

        config(['testing.install.publish_paths' => $publishPaths]);

        $this->app->register(TestInstallationServiceProvider::class);

        // Replace the production catalog with the isolated test catalog.

        $this->app->instance(
            PublishableResourceCatalog::class,
            new TestPublishableResourceCatalog($resources)
        );
    }

    /**
     * Get the destination path of a test resource.
     *
     * @param  string  $key  The key of the resource.
     * @param  string|null  $filename  The optional filename of the resource.
     * @return string The destination path of the resource.
     */
    private function resourceDestination(
        string $key,
        ?string $filename = null
    ): string {
        $filename = $filename !== null ? "{$key}-{$filename}" : "{$key}.txt";

        return $this->testDirectory.'/destinations/'.$filename;
    }

    /**
     * Assert that a resource has been published.
     *
     * @param  string  $key  The key of the resource.
     */
    private function assertResourcePublished(string $key): void
    {
        $this->assertFileExists($this->resourceDestination($key));
    }

    /**
     * Assert that a resource has not been published.
     *
     * @param  string  $key  The key of the resource.
     */
    private function assertResourceNotPublished(string $key): void
    {
        $this->assertFileDoesNotExist($this->resourceDestination($key));
    }
}

/**
 * A test catalog with isolated publishable resources.
 */
class TestPublishableResourceCatalog extends PublishableResourceCatalog
{
    /**
     * Create a new test publishable resource catalog.
     *
     * @param  Collection<string, PublishableResource>  $resources
     */
    public function __construct(private Collection $testResources) {}

    /**
     * Get all publishable resources.
     *
     * @return Collection<string, PublishableResource>
     */
    public function all(): Collection
    {
        return $this->testResources;
    }

    /**
     * Get required publishable resources.
     *
     * @return Collection<string, PublishableResource>
     */
    public function required(): Collection
    {
        return $this->testResources->filter(
            fn (PublishableResource $resource) => $resource->isRequired()
        );
    }

    /**
     * Get optional publishable resources.
     *
     * @return Collection<string, PublishableResource>
     */
    public function optional(): Collection
    {
        return $this->testResources->filter(
            fn (PublishableResource $resource) => $resource->isOptional()
        );
    }

    /**
     * Get a publishable resource by its key.
     */
    public function get(string $key): ?PublishableResource
    {
        return $this->testResources->get($key);
    }
}

/**
 * A publishable resource with isolated publishing paths.
 */
class TestInstallPublishableResource extends PublishableResource
{
    /**
     * Create a new test install publishable resource.
     *
     * @param  string  $key  The key of the resource.
     * @param  string  $name  The name of the resource.
     * @param  string  $tag  The tag of the resource.
     * @param  bool  $required  Whether the resource is required.
     * @param  string  $help  The help text for the resource.
     * @param  array<string, string>  $paths  The publishing paths for the resource.
     */
    public function __construct(
        string $key,
        string $name,
        string $tag,
        bool $required,
        string $help,
        private array $paths,
    ) {
        parent::__construct(
            key: $key,
            name: $name,
            tag: $tag,
            required: $required,
            help: $help,
        );
    }

    /**
     * Get the publishing paths for this resource.
     *
     * @return array<string, string>
     */
    public function getPublishPaths(): array
    {
        return $this->paths;
    }
}

/**
 * A service provider that registers isolated publishing paths for testing.
 */
class TestInstallationServiceProvider extends ServiceProvider
{
    /**
     * Register the test publishing paths.
     */
    public function register(): void
    {
        $publishPaths = config('testing.install.publish_paths', []);

        foreach ($publishPaths as $tag => $paths) {
            $this->publishes($paths, $tag);
        }
    }
}
