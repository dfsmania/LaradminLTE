<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support\Installation;

use DFSmania\LaradminLte\Support\Installation\InstallationResult;
use DFSmania\LaradminLte\Support\Installation\InstallationStatus;
use DFSmania\LaradminLte\Support\Installation\PublishableResource;
use DFSmania\LaradminLte\Tests\TestCase;

class InstallationResultTest extends TestCase
{
    public function test_it_stores_installation_result_properties(): void
    {
        $resource = $this->createStub(PublishableResource::class);
        $status = InstallationStatus::Installed;
        $destinations = [
            'public/vendor/ladmin/css',
            'public/vendor/ladmin/js',
        ];

        $result = new InstallationResult(
            $resource,
            $status,
            $destinations,
        );

        $this->assertSame($resource, $result->resource);
        $this->assertSame($status, $result->status);
        $this->assertSame($destinations, $result->destinations);
    }

    public function test_it_identifies_failed_installations(): void
    {
        $resource = $this->createStub(PublishableResource::class);

        foreach (InstallationStatus::cases() as $status) {
            $result = new InstallationResult($resource, $status, []);

            $this->assertSame(
                $status === InstallationStatus::Failed,
                $result->failed()
            );
        }
    }

    public function test_it_identifies_installed_or_updated_resources(): void
    {
        $resource = $this->createStub(PublishableResource::class);

        foreach (InstallationStatus::cases() as $status) {
            $result = new InstallationResult($resource, $status, []);

            $this->assertSame(
                in_array($status, [
                    InstallationStatus::Installed,
                    InstallationStatus::Updated,
                ], true),
                $result->wasInstalled()
            );
        }
    }
}
