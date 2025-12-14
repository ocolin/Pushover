<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

class Client
{
    public HTTP $http;

    public readonly string $format;

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $token API auth token.
     * @param string $format JSON or XML format to be returned.
     * @param bool $verify Verify SSL connection. Default true.
     * @param int $timeout HTTP timeout. 20 second default.
     */
    public function __construct(
        ?string $token   = null,
         string $format  = 'json',
           bool $verify  = true,
            int $timeout = 20
    )
    {
        $this->format = in_array( needle: $format, haystack: [ 'json', 'xml' ])
            ? $format : 'json';
        $this->http = new HTTP(
              token: $token,
             format: $this->format,
             verify: $verify,
            timeout: $timeout
        );
    }


/* GLANCES CALLS
----------------------------------------------------------------------------- */

    public function glances() : Glances
    {
        return new Glances( client: $this );
    }


/* GROUPS CALLS
----------------------------------------------------------------------------- */

    public function groups() : Groups
    {
        return new Groups( client: $this );
    }


/* LICENSING CALLS
----------------------------------------------------------------------------- */

    public function licenses() : Licenses
    {
        return new Licenses( client: $this );
    }


/* MESSAGE CALLS
----------------------------------------------------------------------------- */

    public function messages() : Messages
    {
        return new Messages( client: $this );
    }


/* RECEIPTS CALLS
----------------------------------------------------------------------------- */

    public function receipts() : Receipts
    {
        return new Receipts( client: $this );
    }


/* SUBSCRIPTIONS CALLS
----------------------------------------------------------------------------- */

    public function subscriptions() : Subscriptions
    {
        return new Subscriptions( client: $this );
    }


/* TEAMS CALLS
----------------------------------------------------------------------------- */

    public function teams() : Teams
    {
        return new Teams( client: $this );
    }


/* USER CALLS
----------------------------------------------------------------------------- */

    public function users() : Users
    {
        return new Users( client: $this );
    }



/* SOUNDS CALLS
----------------------------------------------------------------------------- */

    public function sounds() : Sounds
    {
        return new Sounds( client: $this );
    }



/* LIMIT CALLS
----------------------------------------------------------------------------- */

    public function apps() : Apps
    {
        return new Apps( client: $this );
    }
}