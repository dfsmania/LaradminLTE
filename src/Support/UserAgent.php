<?php

namespace DFSmania\LaradminLte\Support;

use Closure;
use Detection\MobileDetect;

/**
 * User Agent parser class that extends the MobileDetect library to provide
 * additional functionality for parsing the user agent string and extracting
 * information about the device and browser used.
 *
 * @copyright Originally created by Jens Segers:
 * https://github.com/jenssegers/agent
 */
class UserAgent extends MobileDetect
{
    /**
     * List of additional operating systems.
     *
     * A map of operating system names to their corresponding regex patterns
     * for detection in the user agent string. This list is merged with the
     * default operating systems provided by the MobileDetect library to
     * enhance the detection capabilities.
     *
     * @var array<string, string>
     */
    protected static array $additionalOperatingSystems = [
        'Windows' => 'Windows',
        'Windows NT' => 'Windows NT',
        'OS X' => 'Mac OS X',
        'Debian' => 'Debian',
        'Ubuntu' => 'Ubuntu',
        'Macintosh' => 'PPC',
        'OpenBSD' => 'OpenBSD',
        'Linux' => 'Linux',
        'ChromeOS' => 'CrOS',
    ];

    /**
     * List of additional browsers.
     *
     * A map of browser names to their corresponding regex patterns for
     * detection in the user agent string. This list is merged with the
     * default browsers provided by the MobileDetect library to enhance the
     * detection capabilities.
     *
     * @var array<string, string>
     */
    protected static array $additionalBrowsers = [
        'Opera Mini' => 'Opera Mini',
        'Opera' => 'Opera|OPR',
        'Edge' => 'Edge|Edg',
        'Coc Coc' => 'coc_coc_browser',
        'UCBrowser' => 'UCBrowser',
        'Vivaldi' => 'Vivaldi',
        'Chrome' => 'Chrome',
        'Firefox' => 'Firefox',
        'Safari' => 'Safari',
        'IE' => 'MSIE|IEMobile|MSIEMobile|Trident/[.0-9]+',
        'Netscape' => 'Netscape',
        'Mozilla' => 'Mozilla',
        'WeChat' => 'MicroMessenger',
    ];

    /**
     * Key value store for resolved strings.
     *
     * An associative array that serves as a cache for storing resolved values
     * for various keys, such as platform and browser names. This allows for
     * efficient retrieval of previously resolved values without needing to
     * re-parse the user agent string multiple times, improving performance.
     *
     * @var array<string, mixed>
     */
    protected array $store = [];

    /**
     * Get the platform name from the User Agent.
     *
     * @return string|null
     */
    public function platform(): ?string
    {
        // Retrieve the platform name from the cache if it exists, or resolve
        // it by matching the user agent string against the platform rules.

        return $this->retrieveOrResolve('ladmin.platform', function () {
            $rules = $this->mergeRules(
                MobileDetect::getOperatingSystems(),
                static::$additionalOperatingSystems
            );

            return $this->detectFromRules($rules);
        });
    }

    /**
     * Get the browser name from the User Agent.
     *
     * @return string|null
     */
    public function browser(): ?string
    {
        // Retrieve the browser name from the cache if it exists, or resolve it
        // by matching the user agent string against the browser rules.

        return $this->retrieveOrResolve('ladmin.browser', function () {
            $rules = $this->mergeRules(
                MobileDetect::getBrowsers(),
                static::$additionalBrowsers
            );

            return $this->detectFromRules($rules);
        });
    }

    /**
     * Determine if the device is a desktop computer.
     *
     * @return bool
     */
    public function isDesktop(): bool
    {
        return $this->retrieveOrResolve('ladmin.desktop', function () {
            return $this->isCloudFrontDesktop() ||
                (! $this->isMobile() && ! $this->isTablet());
        });
    }

    /**
     * Determine if the device is a desktop computer behind Amazon CloudFront.
     *
     * Amazon CloudFront can add specific headers to the request that indicate
     * whether the viewer is using a desktop or mobile device. This method
     * checks for those headers to determine if the device is a desktop
     * computer, even if the user agent string might not provide that
     * information directly.
     *
     * @return bool
     */
    protected function isCloudFrontDesktop(): bool
    {
        $cloudFrontHeader = 'HTTP_CLOUDFRONT_IS_DESKTOP_VIEWER';

        // When useragent is 'Amazon CloudFront', check for the presence of the
        // 'CloudFront-Is-Desktop-Viewer' header, which is set to 'true' if the
        // viewer is using a desktop device. This allows for accurate detection
        // of desktop devices behind CloudFront.

        return $this->getUserAgent() === static::$cloudFrontUA
            && $this->getHttpHeader($cloudFrontHeader) === 'true';
    }

    /**
     * Detect the matching key from the provided rules based on the user agent
     * string.
     *
     * @param  array<string, string|array<string>>  $rules
     * @return string|null
     */
    protected function detectFromRules(array $rules): ?string
    {
        $userAgent = $this->getUserAgent();

        // Iterate through the provided rules and attempt to match each regex
        // pattern against the user agent string. If a match is found, return
        // the corresponding key, or the first key in the matches array if the
        // key is empty. If no matches are found after iterating through all
        // rules, return null.

        foreach ($rules as $key => $regex) {
            if (empty($regex)) {
                continue;
            }

            // Note that the regex can be either a string or an array of
            // strings. If it's an array, we need to iterate through each
            // pattern in the array and attempt to match it against the user
            // agent string. By casting the regex to an array, we can handle
            // both cases seamlessly and ensure that all patterns are checked
            // for a match.

            foreach ((array) $regex as $pattern) {
                if ($this->match($pattern, $userAgent)) {
                    return $key ?: ($this->matchesArray[0] ?? null);
                }
            }
        }

        return null;
    }

    /**
     * Retrieve the given key from the cache or resolve the value using the
     * provided callback and store it in the cache for future retrievals.
     *
     * @param  string  $key
     * @param  Closure():mixed  $callback
     * @return mixed
     */
    protected function retrieveOrResolve(string $key, Closure $callback): mixed
    {
        // Check if we already have a resolved value for the given key in the
        // cache. If so, return it immediately.

        $cacheKey = $this->createCacheKey($key);
        $cacheItem = $this->store[$cacheKey] ?? null;

        if (! is_null($cacheItem)) {
            return $cacheItem;
        }

        // Otherwise, call the provided callback to resolve the value, store it
        // in the cache using the generated cache key, and return the resolved
        // value.

        return tap($callback(), function ($result) use ($cacheKey) {
            $this->store[$cacheKey] = $result;
        });
    }

    /**
     * Merge multiple rules into one array.
     *
     * @param  array  $all
     * @return array<string, string|array<string>>
     */
    protected function mergeRules(...$all): array
    {
        $merged = [];

        // Iterate through each set of rules provided in the arguments and
        // merge them together into a single array. If a key already exists in
        // the merged array, append the new value to the existing value using a
        // pipe or add it to an array if the existing value is already an array.
        // This allows for multiple regex patterns to be associated with the
        // same key, enabling more comprehensive detection of platforms and
        // browsers.

        foreach ($all as $rules) {
            foreach ($rules as $key => $value) {
                if (! array_key_exists($key, $merged)) {
                    $merged[$key] = $value;
                } elseif (is_array($merged[$key])) {
                    $merged[$key][] = $value;
                } else {
                    $merged[$key] .= '|'.$value;
                }
            }
        }

        // Return the resulting array of merged rules.

        return $merged;
    }
}
