<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

class Groups extends Core
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    public function __construct(
        ?string $token  = null,
        ?string $url    = null,
         string $format = 'json',
           bool $verify = false,
           bool $errors = false,
    )
    {
        $allowed_formats = [ 'json', 'xml' ];
        if( in_array( $format, $allowed_formats )) {
            $this->format = $format;
        }

        parent::__construct(
             token: $token,
               url: $url,
            format: $this->format,
            verify: $verify,
            errors: $errors
        );
    }



/* CREATING A GROUP
----------------------------------------------------------------------------- */

    /**
     * @param string $name Name of group to be created
     * @return object
     */

    public function create( string $name ) : object
    {
        $uri = 'groups.' . $this->format;
        $output = $this->http->post( uri: $uri, params: [ 'name' => $name ] );

        return $output->body;
    }



/* RETRIEVING GROUPS
----------------------------------------------------------------------------- */

    /**
     * @return object List of Groups
     */

    public function listGroups() : object
    {
        $uri = 'groups.json';
        $output = $this->http->get( $uri );

        return $output->body;
    }



/* RETRIEVING INFORMATION ABOUT A GROUP
----------------------------------------------------------------------------- */

    /**
     * @param string $group Key of group to query
     * @return object
     */

    public function get( string $group ) : object
    {
        $uri = 'groups/' . $group . '.' . $this->format;
        $output = $this->http->get( $uri );

        return $output->body;
    }



/* ADDING A USER TO A GROUP
----------------------------------------------------------------------------- */

    /**
     * @param string $user Key of user to add to group
     * @param string $group Group key to add to
     * @param string|null $device Specify optional device
     * @param string|null $memo Add optional memo
     * @return object
     */

    public function addUser(
         string $user,
         string $group,
        ?string $device = null,
        ?string $memo   = null
    ) : object
    {
        $uri = 'groups/' . $group . '/add_user.' . $this->format;
        $params = [ 'user' => $user ];
        if( $device !== null ) { $params['device'] = $device; }
        if( $memo !== null )   { $params['memo'] = $memo; }
        $output = $this->http->post( uri: $uri, params: $params );

        return $output->body;
    }



/* REMOVING A USER FROM A GROUP
----------------------------------------------------------------------------- */

    /**
     * @param string $user User to remove from group
     * @param string $group Group to remove user from
     * @param string|null $device
     * @return object
     */

    public function removeUser(
         string $user,
         string $group,
        ?string $device = null,
    ) : object
    {
        $uri = 'groups/' . $group . '/remove_user.' . $this->format;
        $params = [ 'user' => $user ];
        if( $device !== null ) { $params['device'] = $device; }
        $output = $this->http->post( uri: $uri, params: $params );

        return $output->body;
    }



/* TEMPORARILY DISABLING A USER IN A GROUP
----------------------------------------------------------------------------- */

    /**
     * @param string $user User to disable
     * @param string $group Group to disable in
     * @param string|null $device Optional device
     * @return mixed
     */

    public function disableUser(
         string $user,
         string $group,
        ?string $device = null,
    ) : object
    {
        $uri = 'groups/' . $group . '/disable_user.' . $this->format;
        $params = [ 'user' => $user ];
        if( $device !== null ) { $params['device'] = $device; }
        $output = $this->http->post( uri: $uri, params: $params );

        return $output->body;
    }



/* RE-ENABLING A USER IN A GROUP
----------------------------------------------------------------------------- */

    /**
     * @param string $user User to re-enable
     * @param string $group Group user is in
     * @param string|null $device Optional device
     * @return object
     */

    public function enableUser(
         string $user,
         string $group,
        ?string $device = null
    ) : object
    {
        $uri = 'groups/' . $group . '/enable_user.' . $this->format;
        $params = [ 'user' => $user ];
        if( $device !== null ) { $params['device'] = $device; }
        $output = $this->http->post( uri: $uri, params: $params );

        return $output->body;
    }



/* RENAMING A GROUP
----------------------------------------------------------------------------- */

    /**
     * @param string $group Group to rename
     * @param string $name New name of group
     * @return object
     */

    public function rename( string $group, string $name ) : object
    {
        $uri = 'groups/' . $group . '/rename.' . $this->format;
        $params = [ 'name' => $name ];
        $output = $this->http->post( uri: $uri, params: $params );

        return $output->body;
    }
}