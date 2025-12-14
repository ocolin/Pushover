<?php

/**
 * Pushover: A simple PHP client for Pushover API services.
 *
 * @author  Colin Miller <ocolin@staff.cruzio.com>
 * @copyright Copyright(c) 2025 Colin Miller
 * @license MIT (opensource.org)
 * @version 2.0
 */

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Exception\GuzzleException;

readonly class Apps
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param Client $client Pushover PHP Client.
     */
    public function __construct( private Client $client ) {}



/* GET LIMITS
----------------------------------------------------------------------------- */

    /**
     * Get API client limit information.
     *
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function limits() : object | string
    {
        $uri = 'apps/limits.' . $this->client->format;

        return $this->client->http->get( uri: $uri )->body;
    }
}