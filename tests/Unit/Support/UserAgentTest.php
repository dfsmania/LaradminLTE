<?php

namespace DFSmania\LaradminLte\Tests\Unit\Support;

use DFSmania\LaradminLte\Support\UserAgent;
use DFSmania\LaradminLte\Tests\TestCase;

class UserAgentTest extends TestCase
{
    // ------------------------------------------------------------------------
    // TESTS
    // ------------------------------------------------------------------------

    public function test_it_detects_platform_and_browser(): void
    {
        $agent = $this->agent(
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0'
        );

        // Test the platform and browser detection without cached results.
        $this->assertSame('Windows', $agent->platform());
        $this->assertSame('Chrome', $agent->browser());

        // Test the platform and browser detection with cached results.
        $this->assertSame('Windows', $agent->platform());
        $this->assertSame('Chrome', $agent->browser());
    }

    public function test_it_detects_desktop_and_mobile_devices(): void
    {
        $desktop = $this->agent(
            'Mozilla/5.0 (X11; Linux x86_64) Chrome/120.0'
        );

        $mobile = $this->agent(
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) Mobile'
        );

        $this->assertTrue($desktop->isDesktop());
        $this->assertFalse($mobile->isDesktop());
    }

    public function test_it_detects_cloudfront_desktop_viewers(): void
    {
        $_SERVER['HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER'] = 'true';
        $agent = new CloudFrontUserAgent;

        $this->assertTrue($agent->cloudFrontDesktop());

        $_SERVER['HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER'] = 'false';
        $agent = $this->agent('Amazon CloudFront');

        $this->assertFalse($agent->cloudFrontDesktop());
        unset($_SERVER['HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER']);
    }

    public function test_it_detects_rules_with_multiple_patterns(): void
    {
        $agent = $this->agent('Mozilla/5.0 Firefox/120.0');

        $this->assertSame(
            'Firefox',
            $agent->detectRules([
                'Skipped' => '',
                'Firefox' => ['NoMatch', 'Firefox'],
            ])
        );

        $this->assertSame('Firefox', $agent->detectRules(['' => 'Firefox']));
        $this->assertNull($agent->detectRules([]));
    }

    public function test_it_merges_rules_without_losing_duplicates(): void
    {
        $agent = $this->agent('Test');

        $this->assertSame([
            'one' => 'a|b',
            'many' => ['a', 'b'],
            'new' => 'c',
        ], $agent->merge(
            ['one' => 'a', 'many' => ['a']],
            ['one' => 'b', 'many' => 'b', 'new' => 'c']
        ));
    }

    public function test_it_caches_null_results_as_a_resolved_value(): void
    {
        $agent = $this->agent('Unknown');
        $calls = 0;

        $resolver = function () use (&$calls) {
            $calls++;

            return null;
        };

        $agent->resolve('key', $resolver);
        $agent->resolve('key', $resolver);

        $this->assertSame(2, $calls);
    }

    // ------------------------------------------------------------------------
    // HELPER METHODS
    // ------------------------------------------------------------------------

    /**
     * Create a TestableUserAgent instance with the given user agent string.
     *
     * @param  string  $userAgent
     * @return TestableUserAgent
     */
    private function agent(string $userAgent): TestableUserAgent
    {
        $agent = new TestableUserAgent(
            null,
            ['autoInitOfHttpHeaders' => false]
        );
        $agent->setUserAgent($userAgent);

        return $agent;
    }
}

/**
 * A subclass of UserAgent that exposes protected methods for testing purposes.
 */
class TestableUserAgent extends UserAgent
{
    /**
     * Get the CloudFront desktop status.
     *
     * @return bool
     */
    public function cloudFrontDesktop(): bool
    {
        return $this->isCloudFrontDesktop();
    }

    /**
     * Detect a value based on the given rules.
     *
     * @param  array  $rules
     * @return string|null
     */
    public function detectRules(array $rules): ?string
    {
        return $this->detectFromRules($rules);
    }

    /**
     * Merge multiple sets of rules into one.
     *
     * @param  array  ...$rules
     * @return array
     */
    public function merge(array ...$rules): array
    {
        return $this->mergeRules(...$rules);
    }

    /**
     * Resolve a value for the given key using the provided callback.
     *
     * @param  string  $key
     * @param  \Closure  $callback
     * @return mixed
     */
    public function resolve(string $key, \Closure $callback): mixed
    {
        return $this->retrieveOrResolve($key, $callback);
    }
}

/**
 * A subclass of UserAgent that simulates a CloudFront user agent for testing
 * purposes.
 */
class CloudFrontUserAgent extends TestableUserAgent
{
    /**
     * Get the user agent string.
     *
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return 'Amazon CloudFront';
    }

    /**
     * Get the value of the specified HTTP header.
     *
     * @param  string  $header
     * @return string|null
     */
    public function getHttpHeader(string $header): ?string
    {
        return 'true';
    }
}
