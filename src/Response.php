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

class Response
{
    /**
     * @var int HTTP status code.
     */
    public int $status;

    /**
     * @var string HTTP status message.
     */
    public string $status_message;

    /**
     * @var array<string[]> HTTP headers.
     */
    public array $headers;

    /**
     * @var object|string API response output.
     */
    public object|string $body;
}