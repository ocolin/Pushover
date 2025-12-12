<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Exception\GuzzleException;

readonly class Subscriptions
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    public function __construct( private Client $client ) {}


/* MIGRATE SUBSCRIPTION
----------------------------------------------------------------------------- */

    /**
     * @param string $subscription Your subscription code.
     * @param string $user User's Pushover user key.
     * @param string|null $device_name A user's device name that the
     * subscription should be limited to
     * @param string|null $sound A user's preferred default sound
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function migrate(
         string $subscription,
         string $user,
        ?string $device_name = null,
        ?string $sound = null,
    ) : object | string
    {
        $uri = "subscriptions/migrate." . $this->client->format;
        $params = [
            'subscription' => $subscription,
                    'user' => $user,
        ];
        if( $device_name !== null ) { $params['device_name'] = $device_name; }
        if( $sound !== null ) { $params['sound'] = $sound; }

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }
}