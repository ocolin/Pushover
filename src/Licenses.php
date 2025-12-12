<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Exception\GuzzleException;

readonly class Licenses
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    public function __construct( private Client $client ) {}


/* ASSIGN LICENSE
----------------------------------------------------------------------------- */

    /**
     * To assign a license
     *
     * @param string|null $user User to assign (if not email).
     * @param string|null $email Email to assign (if not user).
     * @param string|null $os Optional OS.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function assign(
        ?string $user  = null,
        ?string $email = null,
        ?string $os    = null
    ) : object | string
    {
        $params = [];
        if( $user !== null )  { $params['user'] = $user; }
        if( $email !== null ) { $params['email'] = $email; }
        if( $os !== null )    { $params['os'] = $os; }
        $uri = 'licenses/assign.' .  $this->client->format;

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }



/* CHECK LICENSE STATUS
----------------------------------------------------------------------------- */

    /**
     * An API call can be made to return the number of license credits
     * remaining without assigning one,
     *
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function check() : object | string
    {
        $uri = 'licenses.' .  $this->client->format;

        return $this->client->http->get( uri: $uri )->body;
    }
}