<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Exception\GuzzleException;

readonly class Devices
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param Client $client Pushover PHP Client.
     */
    public function __construct( private Client $client ) {}


/* REGISTER A DEVICE
----------------------------------------------------------------------------- */

    /**
     * Register a device with a user.
     *
     * @param string $secret User's session secret.
     * @param string $name Name of device. [A-Za-z0-9_-]
     * @param string $os OS of device.
     * @return object|string
     * @throws GuzzleException
     */
    public function register(
        string $secret,
        string $name,
        string $os
    ) : object | string
    {
        $uri = 'devices.' . $this->client->format;
        $params = [
            'secret' => $secret,
            'name'   => $name,
            'os'      => $os
        ];

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }



/* DELETE A DEVICE
----------------------------------------------------------------------------- */

    /**
     * Delete all messages up to the ID of the message specified.
     *
     * @param string $device_id ID of device to delete messages for.
     * @param string $secret User session secret.
     * @param int $message ID of last message to keep.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function delete(
        string $device_id,
        string $secret,
           int $message,
    ) : object | string
    {
        $uri = "devices/{$device_id}/update_highest_message." . $this->client->format;
        $params = [
            'secret'  => $secret,
            'message' => $message,
            'device'  => $device_id
        ];

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }
}