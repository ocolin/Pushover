<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

class Client
{
    public HTTP $http;

    public readonly string $format;

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    public function __construct(
        ?string $url     = null,
        ?string $token   = null,
         string $format  = 'json',
           bool $verify  = true,
           bool $errors  = false,
            int $timeout = 20
    )
    {
        $this->format = $format;
        $this->http = new HTTP(
                url: $url,
              token: $token,
             format: $format,
             verify: $verify,
             errors: $errors,
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
}