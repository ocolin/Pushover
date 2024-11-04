<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use Exception;
use Ocolin\Env\EasyEnv;

class Core
{
    /**
     * @var string Format of returned API data. XML or JSON.
     */
    public string $format = 'json';

    /**
     * @var HTTP Guzzle HTTP handler
     */
    public HTTP $http;

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $token Optional API token.
     * @param string|null $url Optional API URL.
     * @param string $format HTTP output format. XML or JSON.
     * @param bool $verify Verify SSL certificate.
     * @param bool $errors Stop on HTTP errors.
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



/* LOAD ENVIRONMENT VARIABLES
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