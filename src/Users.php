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

readonly class Users
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param Client $client Pushover PHP Client.
     */
    public function __construct( private Client $client ) {}


/* VALIDATE USER
----------------------------------------------------------------------------- */

    /**
     * Validate a user.
     *
     * @param string|null $device Optional device ID to check.
     * @return object|string API response body.
     * @throws GuzzleException
     */
    public function validate( string $user, ?string $device = null ) : object | string
    {
        $options = ['user' => $user ];
        $uri = 'users/validate.' . $this->client->format;
        if( $device !== null ) { $options['device'] = $device ; }

        return $this->client->http->post( uri: $uri, params: $options )->body;
    }



/* LOGIN USER
----------------------------------------------------------------------------- */

    /**
     * Get user's ID and secret.
     *
     * @param string $email Email address of user.
     * @param string $password Password of user.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function login( string $email, string $password ) : object | string
    {
        $uri = 'users/login.' . $this->client->format;
        $query = ['email' => $email, 'password' => $password ];

        return $this->client->http->get( uri: $uri, query: $query )->body;
    }
}