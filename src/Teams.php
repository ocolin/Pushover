<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Exception\GuzzleException;

readonly class Teams
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    public function __construct( private Client $client ) {}


/* SHOW TEAMS
----------------------------------------------------------------------------- */

    /**
     * To show your Team's information including users
     *
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function show() : object | string
    {
        $uri = 'teams.' . $this->client->format;

        return $this->client->http->get( uri: $uri )->body;
    }


/* ADD USER TO TEAM
----------------------------------------------------------------------------- */

    /**
     * To add a user to your Team
     *
     * @param string $email Email address of team member to add.
     * @param array<string, string|int|float> $params Optional parameters.
     * @return object|string
     * @throws GuzzleException
     */
    public function add( string $email, array $params = [] ) : object | string
    {
        $uri = 'teams/add_user.' . $this->client->format;
        $params[ 'email' ] = $email;

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }


/* REMOVE USER
----------------------------------------------------------------------------- */

    /**
     * To remove a user from your Team (without deleting the user's Pushover
     * account) and remove them from any team delivery groups.
     *
     * @param string $email Email address of member to remove from team.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function remove( string $email ) : object | string
    {
        $uri = 'teams/remove_user.' . $this->client->format;
        $params[ 'email' ] = $email;

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }
}