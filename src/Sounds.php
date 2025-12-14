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

readonly class Sounds
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param Client $client Pushover PHP Client.
     */
    public function __construct( private Client $client) {}



/* LIST SOUNDS
----------------------------------------------------------------------------- */

    /**
     * Get list of available alert sounds.
     *
     * @return object|string API server response. Object for JSON, String for XML.
     * @throws GuzzleException
     */
    public function list() : object | string
    {
        $uri = 'sounds.' . $this->client->format;

        return $this->client->http->get( uri: $uri )->body;
    }
}