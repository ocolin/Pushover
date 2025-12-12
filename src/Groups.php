<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Exception\GuzzleException;

readonly class Groups
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    public function __construct( private Client $client ) {}


/* CREATE A NEW GROUP
----------------------------------------------------------------------------- */

    /**
     * To create a new group
     *
     * @param string $name Name of group to create.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function create( string $name ) : object | string
    {
        $uri = 'groups.' . $this->client->format;
        $params = [ 'name' => $name ];

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }


/* GET LIST OF GROUPS
----------------------------------------------------------------------------- */

    /**
     * To fetch a list of groups.
     *
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function groups() : object | string
    {
        $uri = 'groups.' . $this->client->format;

        return $this->client->http->get( uri: $uri )->body;
    }


/* GET A GROUP
----------------------------------------------------------------------------- */

    /**
     * To fetch a list of users in a group and see its name
     *
     * @param string $group ID of group to query.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function get( string $group ) : object | string
    {
        $uri = "groups/{$group}." . $this->client->format;

        return $this->client->http->get( uri: $uri )->body;
    }


/* ADD USER TO GROUP
----------------------------------------------------------------------------- */

    /**
     * To add an existing Pushover user to your Delivery Group,
     *
     * @param string $group Pushover group to add to.
     * @param string $user User to add to group.
     * @param string|null $device Optional device to add.
     * @param string|null $memo A free-text memo used to associate data with the user.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function addUser(
         string $group,
         string $user,
        ?string $device = null,
        ?string $memo = null,
    ) : object | string
    {
        $uri = "groups/{$group}/add_user." . $this->client->format;
        $params = [ 'user' => $user ];
        if( $device !== null ) { $params['device'] = $device ; }
        if( $memo !== null ) { $params['memo'] = $memo ; }

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }


/* REMOVE USER FROM GROUP
----------------------------------------------------------------------------- */

    /**
     * To remove an existing Pushover user to your Delivery Group
     *
     * @param string $group Group to remove user from.
     * @param string $user User to remove from group.
     * @param string|null $device Optional device to remove.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function removeUser(
         string $group,
         string $user,
        ?string $device = null,
    ) : object | string
    {
        $uri = "groups/{$group}/remove_user." . $this->client->format;
        $params = [ 'user' => $user ];
        if( $device !== null ) { $params['device'] = $device ; }

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }


/* DISABLE USER IN GROUP
----------------------------------------------------------------------------- */

    /**
     * To temporarily stop sending notifications to a particular user in a group
     *
     * @param string $group Group to disable user in.
     * @param string $user User to disable in group.
     * @param string|null $device Optional device to disable.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function disableUser(
         string $group,
         string $user,
        ?string $device = null,
    ) : object | string
    {
        $uri = "groups/{$group}/disable_user." . $this->client->format;
        $params = [ 'user' => $user ];
        if( $device !== null ) { $params['device'] = $device ; }

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }


/* ENABLE USER IN GROUP
----------------------------------------------------------------------------- */

    /**
     * To temporarily stop sending notifications to a particular user in a group
     *
     * @param string $group Group to enable user in.
     * @param string $user User to enable in group.
     * @param string|null $device Optional device to enable.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function enableUser(
         string $group,
         string $user,
        ?string $device = null,
    ) : object | string
    {
        $uri = "groups/{$group}/enable_user." . $this->client->format;
        $params = [ 'user' => $user ];
        if( $device !== null ) { $params['device'] = $device ; }

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }



/* RENAME A GROUP
----------------------------------------------------------------------------- */

    /**
     * @param string $group Key of group to rename.
     * @param string $name New name of group.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function rename( string $group, string $name ) : object | string
    {
        $uri = "groups/{$group}/rename." . $this->client->format;

        return $this->client->http->post(
            uri: $uri, params: [ 'name' => $name ]
        )->body;
    }
}