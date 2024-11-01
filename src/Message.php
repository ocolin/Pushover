<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

class Message extends Core
{

/*
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



/* PUSH MESSAGE
----------------------------------------------------------------------------- */

    public function push(
        string $user,
        string $message,
         array $options = []
    ) : object
    {
        $uri = 'messages.' . $this->format;
        $options = self::validate_Options( options: $options );
        $options['user']    = $user;
        $options['message'] = $message;
        $output = $this->http->post( uri: $uri, params: $options );

        return $output->body;
    }



/*
----------------------------------------------------------------------------- */

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

/*
----------------------------------------------------------------------------- */

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

/**
 * POST https://api.pushover.net/1/messages.json
 *
 * REQUIRED:
 * token
 * user
 * message
 *
 * OPTIONAL:
 * attachment
 * attachment_base64
 * attachment_type
 * device
 * html
 * priority
 * sound
 * timestamp
 * title
 * ttl
 * url
 * url_title
 */