<?php

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