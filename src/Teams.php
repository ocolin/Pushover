<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use Exception;

class Teams extends Core
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $token Optional API auth token.
     * @param string|null $url Optional API URL.
     * @param string $format API output format. XML or JSON.
     * @param bool $verify Verify SSL certificate.
     * @param bool $errors Check for HTTP errors.
     * @throws Exception
     */
    public function __construct(
        ?string $token  = null,
        ?string $url    = null,
         string $format = 'json',
           bool $verify = false,
           bool $errors = false,
    ) {
        $allowed_formats = ['json', 'xml'];
        if (in_array($format, $allowed_formats)) {
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



/* ADD USER
----------------------------------------------------------------------------- */

    /**
     * @param string $email Email of user to add to team.
     * @param array<string, string|int|float> $params Optional parameters for user.
     * @return object|string API response object
     */
    public function addUser( string $email, array $params = [] ) : object|string
    {
        $uri = 'teams/add_user.' . $this->format;
        $params = self::validate_Options( options: $params );
        $params['email'] = $email;
        $output = $this->http->post( uri: $uri, params: $params );

        return $output->body;
    }


/* REMOVE USER
----------------------------------------------------------------------------- */

    /**
     * @param string $email Email address of user to remove.
     * @return object|string API response object
     */
    public function removeUser( string $email ) : object|string
    {
        $uri = 'teams/remove_user.' . $this->format;
        $output = $this->http->post( uri: $uri, params: [ 'email' => $email ] );

        return $output->body;
    }



/* VALIDATE OPTIONAL PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @param array<string, string|int|float> $options Array of options sent to client
     * @return array<string, string|int|float> Filtered array of allowed clients from requested ones
     */
    public static function validate_Options( array $options ) : array
    {
        $output = [];
        foreach( $options as $option => $value )
        {
            if( in_array( $option, self::optionalParams() )) {
                $output[$option] = $value;
            }
        }

        return $output;
    }



/* LIST OF OPTIONAL PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[] Array of optional user parameters.
     */
    public static function optionalParams() : array
    {
        return [
            'name',     // the user's full name
            'password', // the user's password if assigning one to the user
            'instant',  // a string value of true will include an Instant Login link
            'admin',    // true will add this user to the team as an administrator
            'group'     // add this user to another Delivery Group
        ];
    }
}