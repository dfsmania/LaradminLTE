<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Installation;

use DFSmania\LaradminLte\LaradminLteServiceProvider;
use DFSmania\LaradminLte\Support\Installation\PublishableResource;
use DFSmania\LaradminLte\Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class PublishableResourceTest extends TestCase
{
    /**
     * The temporary directory used for filesystem tests.
     *
     * @var string
     */
    private string $temporaryDirectory;

    /**
     * Set up the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        // Initialize the temporary directory for this test instance.

        parent::setUp();

        // Create a unique temporary directory for this test instance.

        $this->temporaryDirectory = sys_get_temp_dir()
            .'/laradminlte-installation-'.uniqid();

        File::ensureDirectoryExists($this->temporaryDirectory);
    }

    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_stores_publishable_resource_properties(): void
    {
        $resource = new PublishableResource(
            key: 'assets',
            name: 'AdminLTE Assets',
            tag: 'ladmin-assets',
            required: true,
            help: 'Publish the AdminLTE distribution files.',
        );

        $this->assertSame('assets', $resource->key);
        $this->assertSame('AdminLTE Assets', $resource->name);
        $this->assertSame('ladmin-assets', $resource->tag);
        $this->assertTrue($resource->required);
        $this->assertSame(
            'Publish the AdminLTE distribution files.',
            $resource->help
        );
    }

    public function test_it_identifies_required_and_optional_resources(): void
    {
        $required = $this->resource('required', true);
        $optional = $this->resource('optional', false);

        $this->assertTrue($required->isRequired());
        $this->assertFalse($required->isOptional());

        $this->assertFalse($optional->isRequired());
        $this->assertTrue($optional->isOptional());
    }

    public function test_it_retrieves_registered_publish_paths(): void
    {
        $resource = $this->resource('assets', true, 'ladmin-assets');

        $expected = ServiceProvider::pathsToPublish(
            provider: LaradminLteServiceProvider::class,
            group: 'ladmin-assets',
        );

        $this->assertNotEmpty($expected);
        $this->assertSame($expected, $resource->getPublishPaths());
    }

    public function test_it_inspects_existing_and_missing_files(): void
    {
        $source = $this->tempPath('source.php');
        $destination = $this->tempPath('published.php');

        File::put($source, '<?php return [];');

        $resource = $this->registeredResource([
            $source => $destination,
        ]);

        $this->assertSame([
            'existing' => [],
            'missing' => [$destination],
            'destinations' => [$destination],
        ], $resource->inspect());

        File::put($destination, '<?php return [];');

        $this->assertSame([
            'existing' => [$destination],
            'missing' => [],
            'destinations' => [$destination],
        ], $resource->inspect());
    }

    public function test_it_inspects_directory_files_recursively(): void
    {
        $source = $this->tempPath('source');
        $destination = $this->tempPath('published');

        File::ensureDirectoryExists($source.'/nested');
        File::ensureDirectoryExists($destination.'/nested');

        File::put($source.'/first.php', 'first');
        File::put($source.'/nested/second.php', 'second');

        File::put($destination.'/first.php', 'published');

        $resource = $this->registeredResource([
            $source => $destination,
        ]);

        $inspection = $resource->inspect();

        $this->assertEqualsCanonicalizing(
            [$destination.'/first.php'],
            $inspection['existing']
        );

        $this->assertEqualsCanonicalizing(
            [$destination.'/nested/second.php'],
            $inspection['missing']
        );

        $this->assertSame(
            [$destination],
            $inspection['destinations']
        );
    }

    public function test_it_ignores_invalid_source_paths(): void
    {
        $source = $this->tempPath('nonexistent');
        $destination = $this->tempPath('published');

        $resource = $this->registeredResource([
            $source => $destination,
        ]);

        $this->assertSame([
            'existing' => [],
            'missing' => [],
            'destinations' => [$destination],
        ], $resource->inspect());
    }

    public function test_it_handles_empty_source_directories(): void
    {
        $source = $this->tempPath('empty');
        $destination = $this->tempPath('published');

        File::ensureDirectoryExists($source);

        $resource = $this->registeredResource([
            $source => $destination,
        ]);

        $this->assertSame([
            'existing' => [],
            'missing' => [],
            'destinations' => [$destination],
        ], $resource->inspect());
    }

    public function test_it_returns_unique_destination_paths(): void
    {
        $sourceOne = $this->tempPath('first.php');
        $sourceTwo = $this->tempPath('second.php');
        $destination = $this->tempPath('published.php');

        File::put($sourceOne, 'first');
        File::put($sourceTwo, 'second');

        $resource = $this->registeredResource([
            $sourceOne => $destination,
            $sourceTwo => $destination,
        ]);

        $inspection = $resource->inspect();

        $this->assertSame(
            [$destination],
            $inspection['destinations']
        );

        $this->assertSame(
            [$destination, $destination],
            $inspection['missing']
        );
    }

    // ------------------------------------------------------------------------
    // HELPER METHODS
    // ------------------------------------------------------------------------

    /**
     * Create a publishable resource with the given properties.
     *
     * @param  string  $key
     * @param  bool  $required
     * @param  string|null  $tag
     * @return PublishableResource
     */
    private function resource(
        string $key,
        bool $required = false,
        ?string $tag = null,
    ): PublishableResource {
        return new PublishableResource(
            key: $key,
            name: ucfirst($key),
            tag: $tag ?? 'ladmin-test',
            required: $required,
            help: 'Test resource.',
        );
    }

    /**
     * Create a publishable resource with custom publish paths for testing.
     *
     * @param  array<string, string>  $paths
     * @return TestablePublishableResource
     */
    private function registeredResource(
        array $paths
    ): TestablePublishableResource {
        $resource = new TestablePublishableResource(
            key: 'test',
            name: 'Test',
            tag: 'ladmin-test',
            required: false,
            help: 'Test resource.',
        );

        $resource->setPublishPaths($paths);

        return $resource;
    }

    /**
     * Get a path inside the temporary test directory.
     *
     * @param  string  $path
     * @return string
     */
    private function tempPath(string $path): string
    {
        return $this->temporaryDirectory.'/'.$path;
    }

    /**
     * Remove the temporary directory after each test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        File::deleteDirectory($this->temporaryDirectory);

        parent::tearDown();
    }
}

/**
 * A subclass of PublishableResource that provides custom publish paths
 * for testing purposes.
 */
class TestablePublishableResource extends PublishableResource
{
    /**
     * The publish paths used for testing.
     *
     * @var array<string, string>
     */
    private array $paths = [];

    /**
     * Set the publish paths for testing.
     *
     * @param  array<string, string>  $paths
     * @return void
     */
    public function setPublishPaths(array $paths): void
    {
        $this->paths = $paths;
    }

    /**
     * Get the publish paths configured for testing.
     *
     * @return array<string, string>
     */
    public function getPublishPaths(): array
    {
        return $this->paths;
    }
}
