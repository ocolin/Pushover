<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use Ocolin\GlobalType\GT;

class HTTP
{
    /**
     * @var Client Guzzle HTTP client.
     */
    private Client $client;

    /**
     * @var string API auth token for app.
     */
    private string $token;

    /**
     * @var string The base URL of the API server.
     */
    private string $url;

    /**
     * @var string The API end point URI.
     */
    private string $endpoint;

    /**
     * @var string JSON or XML response.
     */
    private string $format;


/* CONSTRUCTOR
----------------------------------------------------------------------------- */

    /**
     * @param string|null $url Base URL of API server.
     * @param string|null $token API Auth token.
     * @param string $format JSON or XML response format.
     * @param bool $verify Verify SSL connection.
     * @param bool $errors Report HTTP Errors.
     * @param int $timeout HTTP Timeout.
     */
    public function __construct(
        ?string $url,
        ?string $token,
         string $format = 'json',
           bool $verify = true,
           bool $errors = false,
            int $timeout = 20
    )
    {
        $this->token  = $token ?? GT::envString( name: 'PUSHOVER_API_TOKEN' );
        $this->url    = $url   ?? GT::envString( name: 'PUSHOVER_API_URL' );
        $this->format = $format;

        $this->client = new Client([
            'base_uri'        => $this->url,
            'verify'          => $verify,
            'http_errors'     => $errors,
            'timeout'         => $timeout,
            'connect_timeout' => $timeout,
            'headers'         => [
                'Content-Type'  => 'application/json; charset=utf-8',
                'User-Agent'    => 'Pushover PHP Client 2.0',
            ]
        ]);
    }



/* GET REQUEST
----------------------------------------------------------------------------- */

    /**
     * @param string $uri API end point URI.
     * @param string[]|object $query URI query parameters.
     * @return Response Response object from API.
     * @throws GuzzleException
     */
    public function get( string $uri, array|object $query = [] ): Response
    {
        $this->endpoint = $uri;
        $this->trim_Path();
        if( gettype( $query ) === 'object' ) {
            $query = (array)$query;
        }
        if( empty( $query['token'])) { $query['token'] = $this->token; }

        return $this->format_Response( response: $this->client->get(
            uri: $this->endpoint, options: ['query' => $query ]
        ));
    }



/* POST REQUEST
----------------------------------------------------------------------------- */

    /**
     * @param string $uri End point URI.
     * @param array<string, string|int|float>|object $params POST parameters for request body.
     * @return Response Response object from API.
     * @throws GuzzleException
     */
    public function post( string $uri, array|object $params = [] ): Response
    {
        $this->endpoint = $uri;
        $this->trim_Path();
        if( gettype( $params ) === 'object' ) {
            $params = (array)$params;
        }
        $params['token'] = $this->token;

        return $this->format_Response( response: $this->client->post(
            uri: $this->endpoint, options: ['json' => $params ]
        ));
    }


/*
----------------------------------------------------------------------------- */

    /**
     * @param ResponseInterface $response
     * @return Response
     */
    public function format_Response( ResponseInterface $response ): Response
    {
        $output = new Response();
        $output->status         = $response->getStatusCode();
        $output->headers        = $response->getHeaders();
        $output->status_message = $response->getReasonPhrase();
        $output->body           = $response->getBody()->getContents() ?: new stdClass();

        if( $this->format === 'json' AND is_string( $output->body )) {
            $output->body = (object)json_decode( json: $output->body );
        }

        return $output;
    }



/* REMOVE DUPLICATE SLASHES IN URL
----------------------------------------------------------------------------- */

    /**
     * If both the base URL and the end point path have root slash, remove
     * the one from end point to eliminate a double slash in the final URL.
     *
     */
    private function trim_Path() : void
    {
        if(
            str_starts_with( haystack: $this->endpoint, needle: '/' ) AND
            str_ends_with( haystack: $this->url, needle: '/' )
        ) {
            $this->endpoint =  trim( string: $this->endpoint, characters: '/' );
        }
    }
}
