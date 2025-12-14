<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Exception\GuzzleException;

readonly class Limits
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
    public function get() : object | string
    {
        $uri = 'apps/limits.' . $this->client->format;

        return $this->client->http->get( uri: $uri )->body;
    }
}