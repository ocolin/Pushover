<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Exception\GuzzleException;

readonly class Glances
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param Client $client Pushover PHP Client.
     */
    public function __construct( private Client $client ) {}



/* UPDATE WIDGET
----------------------------------------------------------------------------- */

    /**
     * To send an update to your widget,
     *
     * @param string $user User key to update.
     * @param array<string, string|int|float> $params Optional parameters.
     * At least one is needed, such as the text field.
     * @return object|string
     * @throws GuzzleException
     */
    public function update( string $user, array $params = [] ) : object | string
    {
        $uri = 'glances.' . $this->client->format;
        $params['user'] = $user;

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }
}