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

use GuzzleHttp\Exception\GuzzleException;

readonly class Receipts
{

/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param Client $client Pushover PHP Client.
     */
    public function __construct( private Client $client ) {}


/* GET A TASK RECEIPT
----------------------------------------------------------------------------- */

    /**
     * Get a specific receipt.
     *
     * @param string $receipt ID of the receipt to check.
     * @return object|string Status of task receipt belongs to.
     * @throws GuzzleException
     */
    public function get( string $receipt ) : object | string
    {
        $uri = "receipts/{$receipt}." . $this->client->format;

        return $this->client->http->get( uri: $uri )->body;
    }



/* CANCEL TASK
----------------------------------------------------------------------------- */

    /**
     * Cancel an emergency message push.
     *
     * @param string $receipt ID of receipt for task to cancel.
     * @return object|string Response from API server.
     * @throws GuzzleException
     */
    public function cancel( string $receipt ) : object | string
    {
        $uri = "receipts/{$receipt}/cancel." . $this->client->format;

        return $this->client->http->post( uri: $uri )->body;
    }



/* CANCEL TASKS BY TAG VALUE
----------------------------------------------------------------------------- */

    /**
     * Cancel an emergency message by a tag.
     *
     * @param string $tag Tag of task(s) to cancel.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function cancelByTag( string $tag ) : object | string
    {
        $uri = "receipts/cancel_by_tag/{$tag}." . $this->client->format;

        return $this->client->http->post( uri: $uri )->body;
    }


/* ACKNOWLEDGE EMERGENCY MESSAGE
----------------------------------------------------------------------------- */

    /**
     * Send an acknowledgement of an emergency push from a device.
     *
     * @param string $receipt Receipt ID to acknowledge.
     * @param string $secret User session secret.
     * @return object|string API server response.
     * @throws GuzzleException
     */
    public function acknowledge( string $receipt, string $secret ) : object | string
    {
        $uri = "receipts/{$receipt}/acknowledge." . $this->client->format;
        $params['secret'] = $secret;

        return $this->client->http->post( uri: $uri, params: $params )->body;
    }
}