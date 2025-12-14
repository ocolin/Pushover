<?php

/**
 * Pushover: A simple PHP client for Pushover API services.
 *
 * @author  Colin Miller <ocolin@staff.cruzio.com>
 * @copyright Copyright(c) 2025 Colin Miller
 * @license MIT (opensource.org)
 * @version 2.0
 */

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use Exception;
use GuzzleHttp\Exception\GuzzleException;

readonly class Messages
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param Client $client Pushover PHP Client.
     */
    public function __construct( private Client $client ) {}


/* PUSH MESSAGE
----------------------------------------------------------------------------- */

    /**
     * Push a message to a user or group.
     *
     * @param string $user User or group to send message to.
     * @param string $message Message to send.
     * @param array<string, string|int|float> $params Optional parameters.
     * @return object|string
     * @throws GuzzleException
     * @throws Exception
     */
    public function push(
        string $user,
        string $message,
         array $params = []
    ) : object | string
    {
        $uri = 'messages.' . $this->client->format;
        $params['user']    = $user;
        $params['message'] = $message;

        if( !empty( $params['attachment'] )) {
            return $this->client->http->multipart( uri: $uri, params: $params )->body;
        }

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }



/* GET MESSAGES
----------------------------------------------------------------------------- */

    /**
     * Download all existing messages waiting for a device.
     *
     * @param string $secret Secret of user.
     * @param string $device_id ID of user's device to get messages for.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function get(
        string $secret,
        string $device_id
    ) : object | string
    {
        $uri = 'messages.' . $this->client->format;
        $query = [
            'device_id' => $device_id,
            'secret'    => $secret,
        ];

        return $this->client->http->get( uri: $uri, query: $query )->body;
    }
}