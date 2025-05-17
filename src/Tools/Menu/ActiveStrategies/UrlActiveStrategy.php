<?php

namespace DFSmania\LaradminLte\Tools\Menu\ActiveStrategies;

use DFSmania\LaradminLte\Tools\Menu\Contracts\ActiveStrategy;
use Illuminate\Support\Str;

/**
 * Class UrlActiveStrategy
 *
 * This class implements the ActiveStrategy interface to determine if a menu
 * item is currently active by comparing its URL with the current request's URL.
 */
class UrlActiveStrategy implements ActiveStrategy
{
    /**
     * The full URL to check against the current request's URL.
     *
     * @var string
     */
    protected string $url;

    /**
     * Create a new class instance.
     *
     * @param  string  $url  The URL to check against the current request's URL
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Determines whether the stored URL is active based on the current
     * request's URL.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        // Verify if the request's URL matches the absolute path of the stored
        // URL. If the absolute path includes query parameters, compare it with
        // the full request's URL.

        $pattern = preg_replace('@^https?://@', '*', $this->url);

        $requestUrl = isset(parse_url($pattern)['query'])
            ? request()->fullUrl()
            : request()->url();

        return Str::is(trim($pattern), trim($requestUrl));
    }
}
