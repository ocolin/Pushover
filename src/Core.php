<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use Exception;
use Ocolin\Env\EasyEnv;

class Core
{
    public string $format = 'json';

    public HTTP $http;

/*
----------------------------------------------------------------------------- */

    /**
     * @param string|null $token
     * @param string|null $url
     * @param string $format HTTP output format
     * @param bool $verify
     * @param bool $errors
     * @throws Exception
     */
    public function __construct(
        ?string $token  = null,
        ?string $url    = null,
         string $format = 'json',
           bool $verify = false,
           bool $errors = false,
    )
    {
        self::load_Env();
        $this->http = new HTTP(
             token: $token,
               url: $url,
            format: $format,
            verify: $verify,
            errors: $errors
        );
    }



/*
----------------------------------------------------------------------------- */

    /**
     * @throws Exception
     */
    public static function load_Env() : void
    {
        if(
            empty( $_ENV['PUSHOVER_API_TOKEN']) OR
            empty( $_ENV['PUSHOVER_API_URL'])
        )
        {
            EasyEnv::loadEnv(
                  path: __DIR__ . '/../.env',
                append: true
            );
        }
    }
}