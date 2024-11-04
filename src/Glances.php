<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

class Glances extends Core
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



/* PUSH GLANCE
----------------------------------------------------------------------------- */

    /**
     * @param string $user User key for user pushing glance.
     * @param string|null $device Optional user device.
     * @param array<string,string|int|float> $params Parameters to send in glance.
     * @return object|string API response object.
     */
    public function push(
        string $user,
        string $device = null ,
         array $params = []
    ) : object|string
    {
        $uri = 'glances.' . $this->format;
        $params = self::validate_Data( params: $params );
        if( $device !== null ) { $params['device'] = $device; }
        $params['user'] = $user;
        $output = $this->http->post( uri: $uri, params: $params );

        return $output->body;
    }



/* VALIDATE PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @param array<string, string|int|float> $params Submitted parameters
     * @return array<string, string|int|float> filtered parameters
     */
    public static function validate_Data( array $params ) : array
    {
        $output = [];
        foreach( $params as $param => $value )
        {
            if( in_array( $param, self::dataParams() )) {
                $output[$param] = $value;
            }
        }

        return $output;
    }



/* ALLOWED DATA PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[] Array of allowed parameters
     */
    public static function dataParams() : array
    {
        return [
            'title',
            'text',
            'subtext',
            'count',
            'percent'
        ];
    }
}