<?php

namespace DFSmania\LaradminLte\Support\Auth\Session;

/**
 * Class representing a browser session for the authenticated user.
 */
class BrowserSession
{
    /**
     * The user agent instance with the browser and device information.
     *
     * @var UserAgent
     */
    public UserAgent $agent;

    /**
     * The IP address of the browser session.
     *
     * @var string
     */
    public string $ipAddress;

    /**
     * Indicates if this session is for the current device.
     *
     * @var bool
     */
    public bool $isCurrentDevice;

    /**
     * The last active time of the session.
     *
     * @var string
     */
    public string $lastActive;

    /**
     * Create a new browser session instance.
     *
     * @param  UserAgent  $agent
     * @param  string  $ipAddress
     * @param  bool  $isCurrentDevice
     * @param  string  $lastActive
     */
    public function __construct(
        UserAgent $agent,
        string $ipAddress,
        bool $isCurrentDevice,
        string $lastActive,
    ) {
        $this->agent = $agent;
        $this->ipAddress = $ipAddress;
        $this->isCurrentDevice = $isCurrentDevice;
        $this->lastActive = $lastActive;
    }
}
