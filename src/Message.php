<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

class Message extends Core
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $token Optional API token.
     * @param string|null $url Optional API URL.
     * @param string $format Format of response data. XML or JSON.
     * @param bool $verify Verify SSL cert.
     * @param bool $errors Verify no HTTP errors.
     * @throws \Exception
     */
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



/* PUSH MESSAGE
----------------------------------------------------------------------------- */

    /**
     * @param string $user User key of user that is sending message.
     * @param string $message Message content itself.
     * @param array<string, string|int|float> $options Optional parameters for message.
     * @return object|string API response object
     */
    public function push(
        string $user,
        string $message,
         array $options = []
    ) : object|string
    {
        $uri = 'messages.' . $this->format;
        $options = self::validate_Options( options: $options );
        $options['user']    = $user;
        $options['message'] = $message;
        $output = $this->http->post( uri: $uri, params: $options );

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



/* OPTIONAL PARAMETERS
----------------------------------------------------------------------------- */

    /**
     * @return string[] Array of allowed parameters.
     */
    public static function optionalParams() : array
    {
        return [
            'attachment',
            'attachment_base64',
            'attachment_type',
            'device',
            'html',
            'priority',
            'sound',
            'timestamp',
            'title',
            'ttl',
            'url',
            'url_title',
            'expire',
            'retry'
        ];
    }
}